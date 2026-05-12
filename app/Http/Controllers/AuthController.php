<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'И-мэйл хаяг оруулна уу',
            'email.email'       => 'Зөв и-мэйл хаяг оруулна уу',
            'password.required' => 'Нууц үг оруулна уу',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            $request->session()->regenerate();

            if ($request->user()->is_admin) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'И-мэйл эсвэл нууц үг буруу байна.',
        ])->withInput($request->only('email'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'И-мэйл хаяг оруулна уу',
            'email.email' => 'Зөв и-мэйл хаяг оруулна уу',
            'email.exists' => 'Энэ и-мэйл бүртгэлгүй байна',
        ]);

        $code = (string) random_int(100000, 999999);
        $email = strtolower($data['email']);

        Cache::put($this->resetCodeCacheKey($email), [
            'code' => Hash::make($code),
        ], now()->addMinutes(10));

        try {
            Mail::raw("GlowMN нууц үг сэргээх код: {$code}\n\nЭнэ код 10 минут хүчинтэй.", function ($message) use ($email) {
                $message->to($email)->subject('GlowMN нууц үг сэргээх код');
            });
        } catch (Throwable $e) {
            report($e);

            return back()->withErrors([
                'email' => 'Код илгээхэд алдаа гарлаа. Gmail mail тохиргоогоо шалгана уу.',
            ])->withInput();
        }

        $redirect = redirect()
            ->route('password.verify', ['email' => $email])
            ->with('success', '6 оронтой код таны и-мэйл рүү илгээгдлээ.');

        if (config('mail.default') === 'log') {
            $redirect->with('debug_code', $code);
        }

        return $redirect;
    }

    public function showVerifyResetCode(Request $request)
    {
        return view('auth.verify-reset-code', [
            'email' => $request->query('email'),
        ]);
    }

    public function verifyResetCode(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|digits:6',
        ], [
            'email.required' => 'И-мэйл хаяг оруулна уу',
            'code.required' => '6 оронтой код оруулна уу',
            'code.digits' => 'Код 6 оронтой тоо байх ёстой',
        ]);

        $email = strtolower($data['email']);
        $payload = Cache::get($this->resetCodeCacheKey($email));

        if (!$payload || !Hash::check($data['code'], $payload['code'])) {
            return back()->withErrors([
                'code' => 'Код буруу эсвэл хугацаа дууссан байна.',
            ])->withInput($request->only('email'));
        }

        $request->session()->put('password_reset_verified_email', $email);

        return redirect()
            ->route('password.reset')
            ->with('success', 'Код баталгаажлаа. Одоо шинэ нууц үгээ оруулна уу.');
    }

    public function showResetPassword(Request $request)
    {
        $email = $request->session()->get('password_reset_verified_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $email = $request->session()->get('password_reset_verified_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $data = $request->validate([
            'password' => 'required|confirmed|min:8',
        ], [
            'password.required' => 'Шинэ нууц үг оруулна уу',
            'password.confirmed' => 'Нууц үг таарахгүй байна',
            'password.min' => 'Нууц үг хамгийн багадаа 8 тэмдэгт байх ёстой',
        ]);

        User::where('email', $email)->update([
            'password' => Hash::make($data['password']),
        ]);

        Cache::forget($this->resetCodeCacheKey($email));
        $request->session()->forget('password_reset_verified_email');

        return redirect()->route('login')->with('success', 'Нууц үг амжилттай шинэчлэгдлээ. Одоо нэвтэрнэ үү.');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ], [
            'name.required'      => 'Нэрээ оруулна уу',
            'email.required'     => 'И-мэйл хаяг оруулна уу',
            'email.unique'       => 'Энэ и-мэйл аль хэдийн бүртгэлтэй байна',
            'password.required'  => 'Нууц үг оруулна уу',
            'password.confirmed' => 'Нууц үг таарахгүй байна',
            'password.min'       => 'Нууц үг хамгийн багадаа 8 тэмдэгт байх ёстой',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Тавтай морилно уу, ' . $user->name . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    private function resetCodeCacheKey(string $email): string
    {
        return 'password_reset_code:' . sha1(strtolower($email));
    }
}
