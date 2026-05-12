@extends('layouts.app')
@section('title', 'Шинэ нууц үг - GlowMN')


@section('content')
<section class="auth-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="auth-card">
          <div class="text-center mb-4">
            <div style="font-size:2.2rem; color:var(--primary)">✿</div>
            <h2 class="auth-title">Шинэ нууц үг</h2>
            <p class="auth-subtitle">{{ $email }} хаягийн нууц үгийг шинэчилнэ</p>
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

          <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <div class="mb-3">
              <label class="form-label">Шинэ нууц үг</label>
              <input type="password" name="password"
                class="form-control form-control-lg @error('password') is-invalid @enderror"
                placeholder="••••••••" required autofocus>
            </div>

            <div class="mb-4">
              <label class="form-label">Шинэ нууц үг давтах</label>
              <input type="password" name="password_confirmation"
                class="form-control form-control-lg"
                placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold" style="font-size:16px">
              Нууц үг шинэчлэх
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
