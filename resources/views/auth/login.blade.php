@extends('layouts.app')
@section('title', 'Нэвтрэх - GlowMN')


@section('content')
<section class="auth-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="auth-card">

          <div class="text-center mb-4">
            <div style="font-size:2.2rem; color:var(--purple)">✿</div>
            <h2 class="auth-title">Нэвтрэх</h2>
            <p class="auth-subtitle">GlowMN-д тавтай морилно уу</p>
          </div>

          @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-3" style="font-size:14px">
              <i class="fa fa-exclamation-circle me-2"></i>{{ $errors->first() }}
            </div>
          @endif

          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
              <label class="form-label">И-мэйл хаяг</label>
              <input type="email" name="email"
                class="form-control form-control-lg @error('email') is-invalid @enderror"
                placeholder="example@mail.com"
                value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-4">
              <label class="form-label">Нууц үг</label>
              <div class="input-group">
                <input type="password" name="password" id="pw"
                  class="form-control form-control-lg @error('password') is-invalid @enderror"
                  placeholder="••••••••" required>
                <button type="button" class="input-group-text toggle-password"
                  data-target="#pw" style="cursor:pointer; border-left:none">
                  <i class="fa fa-eye"></i>
                </button>
              </div>
            </div>

            <div class="form-check mb-4">
              <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label class="form-check-label" for="remember" style="font-size:14px">Намайг санах</label>
            </div>

            <div class="text-end mb-4" style="font-size:14px">
              <a href="{{ route('password.request') }}" style="color:var(--primary); font-weight:600; text-decoration:none">
                Нууц үг мартсан?
              </a>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold" style="font-size:16px">
              Нэвтрэх
            </button>
          </form>

          <div class="text-center mt-4" style="font-size:14px">
            Бүртгэл байхгүй юу?
            <a href="{{ route('register') }}" style="color:var(--purple); font-weight:600">Бүртгүүлэх</a>
          </div>

          <div class="text-center mt-2">
            <a href="{{ route('test.show') }}" style="font-size:13px; color:var(--gray); text-decoration:none">
              Бүртгэлгүйгээр тест өгөх →
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
