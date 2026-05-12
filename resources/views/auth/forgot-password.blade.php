@extends('layouts.app')
@section('title', 'Нууц үг сэргээх - GlowMN')

@section('content')
<section class="auth-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="auth-card">
          <div class="text-center mb-4">
            <div style="font-size:2.2rem; color:var(--primary)">✿</div>
            <h2 class="auth-title">Нууц үг сэргээх</h2>
            <p class="auth-subtitle">Бүртгэлтэй и-мэйл рүү 6 оронтой код илгээнэ</p>
          </div>

          @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-3" style="font-size:14px">
              <i class="fa fa-exclamation-circle me-2"></i>{{ $errors->first() }}
            </div>
          @endif

          @if(session('success'))
            <div class="alert alert-success rounded-3 mb-3" style="font-size:14px">
              <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            </div>
          @endif

          <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
              <label class="form-label">И-мэйл хаяг</label>
              <input type="email" name="email"
                class="form-control form-control-lg @error('email') is-invalid @enderror"
                placeholder="example@mail.com"
                value="{{ old('email') }}" required autofocus>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold" style="font-size:16px">
              Код авах
            </button>
          </form>

          <div class="text-center mt-4" style="font-size:14px">
            <a href="{{ route('login') }}" style="color:var(--primary); font-weight:600">Нэвтрэх рүү буцах</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
