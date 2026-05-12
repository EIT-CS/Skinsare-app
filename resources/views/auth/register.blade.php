@extends('layouts.app')
@section('title', 'Бүртгүүлэх - GlowMN')

@section('content')
<section class="auth-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="auth-card">

          <div class="text-center mb-4">
            <div style="font-size:2.2rem; color:var(--purple)">✿</div>
            <h2 class="auth-title">Бүртгүүлэх</h2>
            <p class="auth-subtitle">Хурдан бүртгүүлж эхлээрэй</p>
          </div>

          @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-3" style="font-size:14px">
              <ul class="mb-0 ps-3">
                @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
              <label class="form-label">Нэр</label>
              <input type="text" name="name"
                class="form-control form-control-lg @error('name') is-invalid @enderror"
                placeholder="Таны нэр"
                value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-3">
              <label class="form-label">И-мэйл хаяг</label>
              <input type="email" name="email"
                class="form-control form-control-lg @error('email') is-invalid @enderror"
                placeholder="example@mail.com"
                value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Нууц үг</label>
              <div class="input-group">
                <input type="password" name="password" id="pw"
                  class="form-control form-control-lg @error('password') is-invalid @enderror"
                  placeholder="Хамгийн багадаа 8 тэмдэгт" required>
                <button type="button" class="input-group-text toggle-password"
                  data-target="#pw" style="cursor:pointer; border-left:none">
                  <i class="fa fa-eye"></i>
                </button>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label">Нууц үг давтах</label>
              <input type="password" name="password_confirmation"
                class="form-control form-control-lg"
                placeholder="Нууц үгийг давтах" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold" style="font-size:16px">
              Бүртгүүлэх
            </button>
          </form>

          <div class="text-center mt-4" style="font-size:14px">
            Аль хэдийн бүртгэлтэй юу?
            <a href="{{ route('login') }}" style="color:var(--purple); font-weight:600">Нэвтрэх</a>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
