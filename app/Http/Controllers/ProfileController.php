<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user    = Auth::user();
        $history = $user->skinTestResults()->orderByDesc('created_at')->get();
        return view('profile.show', compact('user', 'history'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'avatar'    => 'nullable|image|max:2048',
        ], [
            'name.required' => 'Нэрээ оруулна уу',
            'avatar.image'  => 'Зөвхөн зураг байршуулна уу',
            'avatar.max'    => 'Зурагны хэмжээ 2MB-аас хэтрэхгүй байх ёстой',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Профайл амжилттай шинэчлэгдлээ!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|confirmed|min:8',
        ], [
            'current_password.required' => 'Одоогийн нууц үгийг оруулна уу',
            'password.required'         => 'Шинэ нууц үг оруулна уу',
            'password.confirmed'        => 'Нууц үг таарахгүй байна',
            'password.min'              => 'Нууц үг хамгийн багадаа 8 тэмдэгт байх ёстой',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Одоогийн нууц үг буруу байна']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Нууц үг амжилттай солигдлоо!');
    }
}
