@extends('layouts.app')
@section('title', 'Профайл засах - GlowMN')

@section('content')
<div class="page-header section-with-wave">
    <div class="container page-header-content">
        <h1>✏️ Профайл засах</h1>
    </div>
    <div class="wave" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
            <path d="M0,35 C300,70 600,0 900,35 L1200,35 L1200,70 L0,70 Z" fill="#f8f9fa"></path>
        </svg>
    </div>
</div>

<section class="section-padding section-with-wave" style="background:var(--gray-1); padding-top:40px">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <!-- Edit Profile Form -->
                <div class="profile-card">
                    <h6 class="fw-bold mb-4"><i class="fa fa-user-edit me-2" style="color:var(--primary)"></i>Мэдээлэл засах</h6>

                    @if($errors->any())
                    <div class="alert alert-danger rounded-3 mb-3" style="font-size:14px">
                        <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <!-- Avatar -->
                        <div class="mb-4 text-center">
                            <img src="{{ $user->avatar_url }}" id="avatarPreview"
                                 style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid var(--primary);margin-bottom:12px">
                            <div>
                                <label class="btn btn-outline-primary btn-sm" style="cursor:pointer">
                                    <i class="fa fa-camera me-1"></i>Зураг сонгох
                                    <input type="file" name="avatar" class="d-none" accept="image/*" data-preview="#avatarPreview">
                                </label>
                            </div>
                            <div class="text-muted mt-1" style="font-size:12px">JPG, PNG – 2MB хүртэл</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Бүтэн нэр <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold">
                            <i class="fa fa-save me-2"></i>Хадгалах
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Change Password -->
                <div class="profile-card">
                    <h6 class="fw-bold mb-4"><i class="fa fa-lock me-2" style="color:var(--primary)"></i>Нууц үг солих</h6>
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Одоогийн нууц үг</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="••••••••">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Шинэ нууц үг</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Хамгийн багадаа 8 тэмдэгт">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Шинэ нууц үг давтах</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                        </div>
                        <button type="submit" class="btn btn-outline-primary w-100 py-3 fw-semibold">
                            <i class="fa fa-key me-2"></i>Нууц үг солих
                        </button>
                    </form>
                </div>

                <!-- Back Link -->
                <div class="text-center mt-3">
                    <a href="{{ route('profile.show') }}" class="text-muted" style="font-size:14px; text-decoration:none">
                        ← Профайл руу буцах
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="wave" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
            <path d="M0,35 C300,70 600,0 900,35 L1200,35 L1200,70 L0,70 Z" fill="#5f3a9f"></path>
        </svg>
    </div>
</section>
@endsection

