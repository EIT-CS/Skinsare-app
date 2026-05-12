@extends('layouts.app')
@section('title', 'Код баталгаажуулах - GlowMN')

@section('content')
<section class="auth-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="auth-card">
          <div class="text-center mb-4">
            <div style="font-size:2.2rem; color:var(--primary)">✿</div>
            <h2 class="auth-title">Код баталгаажуулах</h2>
            <p class="auth-subtitle">И-мэйлээр ирсэн 6 оронтой кодоо оруулна уу</p>
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

          @if(session('debug_code'))
            <div class="alert rounded-3 mb-3 text-center" style="font-size:14px; background:var(--primary-light); color:var(--primary); border:1px solid rgba(122,69,209,0.18)">
              <div class="fw-semibold mb-1">Local mail mode code</div>
              <div style="font-size:28px; font-weight:800; letter-spacing:6px">{{ session('debug_code') }}</div>
            </div>
          @endif

          <form method="POST" action="{{ route('password.verify.submit') }}">
            @csrf

            <div class="mb-3">
              <label class="form-label">И-мэйл хаяг</label>
              <input type="email" name="email"
                class="form-control form-control-lg @error('email') is-invalid @enderror"
                value="{{ old('email', $email) }}"
                placeholder="example@mail.com" required>
            </div>

            <div class="mb-4">
              <label class="form-label">6 оронтой код</label>
              <input type="text" name="code"
                class="form-control form-control-lg text-center @error('code') is-invalid @enderror"
                inputmode="numeric" pattern="[0-9]{6}" maxlength="6"
                placeholder="000000" value="{{ old('code') }}" required autofocus>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold" style="font-size:16px">
              Код баталгаажуулах
            </button>
          </form>

          <div class="text-center mt-4" style="font-size:14px">
            <a href="{{ route('password.request') }}" style="color:var(--primary); font-weight:600">Код дахин авах</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
