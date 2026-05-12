@extends('layouts.app')
@section('title', 'Зөвлөгөө - GlowMN')

@section('content')
<div class="page-header">
    <div class="container page-header-content">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Нүүр</a></li>
                <li class="breadcrumb-item active">Зөвлөгөө</li>
            </ol>
        </nav>
        <h1>💡 Арьс арчилгааны зөвлөгөө</h1>
        <p>Арьсны төрлөөр тохирсон өдөр тутмын зөв дадлыг хараарай</p>
    </div>
</div>

<section class="section-padding section-with-wave" style="background: var(--gray-1); padding-top: 40px">
    <div class="container">

        <div class="filter-bar">
            <span class="fw-semibold me-2" style="font-size:14px; white-space:nowrap">
                <i class="fa fa-filter me-1" style="color:var(--primary)"></i>Арьсны төрөл:
            </span>
            <button class="filter-btn {{ !$skinType ? 'active' : '' }}" data-filter="" data-filter-key="skin_type">Бүгд</button>
            <button class="filter-btn {{ $skinType === 'dry' ? 'active' : '' }}" data-filter="dry" data-filter-key="skin_type">💧 Хуурай</button>
            <button class="filter-btn {{ $skinType === 'oily' ? 'active' : '' }}" data-filter="oily" data-filter-key="skin_type">✨ Тослог</button>
            <button class="filter-btn {{ $skinType === 'combination' ? 'active' : '' }}" data-filter="combination" data-filter-key="skin_type">⚖️ Холимог</button>
            <button class="filter-btn {{ $skinType === 'normal' ? 'active' : '' }}" data-filter="normal" data-filter-key="skin_type">🌸 Хэвийн</button>
            <button class="filter-btn {{ $skinType === 'sensitive' ? 'active' : '' }}" data-filter="sensitive" data-filter-key="skin_type">🌿 Мэдрэмтгий</button>
        </div>

        <div class="row g-4 mt-1">
            @forelse(($tips ?? collect()) as $tip)
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="profile-card h-100">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span style="font-size:1.2rem">{{ $tip->icon ?: '💡' }}</span>
                        <span class="badge" style="background:var(--primary-light); color:var(--primary)">{{ $tip->category_label }}</span>
                    </div>
                    <h5 class="fw-bold mb-2">{{ $tip->title }}</h5>
                    <p class="text-muted mb-3">{{ $tip->content }}</p>

                    <div class="d-flex flex-wrap gap-2 mt-auto">
                        @foreach(($tip->suitable_for ?? []) as $st)
                            <span class="skin-tag {{ $st }}">{{ ucfirst($st) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <span class="empty-state-icon">📝</span>
                    <h5 class="fw-bold mb-2">Зөвлөгөө олдсонгүй</h5>
                    <p class="text-muted">Шүүлтүүрээ өөрчлөөд дахин оролдоно уу.</p>
                </div>
            </div>
            @endforelse
        </div>

    </div>
    <div class="wave" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
            <path d="M0,35 C300,70 600,0 900,35 L1200,35 L1200,70 L0,70 Z" fill="#5f3a9f"></path>
        </svg>
    </div>
</section>
@endsection
