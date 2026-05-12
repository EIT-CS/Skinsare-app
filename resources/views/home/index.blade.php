@extends('layouts.app')
@section('title', 'GlowMN - Арьс Арчилгааны Платформ')

@section('content')

<!-- HERO SECTION -->
<section class="hero-section section-with-wave">
    <div class="hero-bg">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="hero-blob hero-blob-3"></div>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-100 pt-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="hero-badge mb-3">
                    <span>✨ Монгол хэрэглэгчдэд зориулсан</span>
                </div>
                <h1 class="hero-title">
                    Таны арьсны<br>
                    <span class="hero-title-accent">гоо үзэсгэлэнг</span><br>
                    нээж олъё
                </h1>
                <p class="hero-subtitle">
                    Шинжлэх ухааны үндэслэлтэй арьсны тест авч, арьсны төрлөөрөө
                    тохирсон зөвлөгөө болон бүтээгдэхүүний санал аваарай.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('test.show') }}" class="btn btn-hero-primary">
                        <i class="fa fa-flask me-2"></i>Арьсны тест өгөх
                    </a>
                    <a href="{{ route('tips.index') }}" class="btn btn-hero-secondary">
                        Зөвлөгөө үзэх <i class="fa fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="hero-stats mt-4">
                    <div class="hero-stat">
                        <span class="hero-stat-num">5+</span>
                        <span class="hero-stat-label">Арьсны төрөл</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <span class="hero-stat-num">20+</span>
                        <span class="hero-stat-label">Бүтээгдэхүүн</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <span class="hero-stat-num">8</span>
                        <span class="hero-stat-label">Асуулт бүхий тест</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left">
                <div class="hero-visual">
                    <div class="hero-card-float hero-card-1">
                        <div class="d-flex align-items-center gap-2">
                            <div class="skin-type-dot oily"></div>
                            <span>Тослог арьс</span>
                        </div>
                    </div>
                    <div class="hero-card-float hero-card-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fs-5">💧</span>
                            <div>
                                <div class="fw-semibold small">Чийгшүүлэх зөвлөгөө</div>
                                <div class="text-muted" style="font-size:11px">Хуурай арьсанд</div>
                            </div>
                        </div>
                    </div>
                    <div class="hero-card-float hero-card-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fs-5">✅</span>
                            <span class="small fw-semibold">Тест дууслаа!</span>
                        </div>
                    </div>
                    <div class="hero-skin-visual">
                        <div class="hero-skin-circle">
                            <span class="hero-skin-emoji">🌸</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wave" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
            <path d="M0,35 C300,70 600,0 900,35 L1200,35 L1200,70 L0,70 Z" fill="#f4effb"></path>
        </svg>
    </div>
</section>

<!-- SKIN TYPES SECTION -->
<section class="section-padding home-section-lilac section-with-wave">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-badge">Арьсны төрлүүд</div>
            <h2 class="section-title">Арьсны 5 үндсэн төрөл</h2>
            <p class="section-subtitle">Арьсны төрлийг мэдэх нь зөв арчилгааны эхний алхам юм</p>
        </div>
        <div class="row g-4">
            @php
            $skinTypes = [
                ['type' => 'dry', 'label' => 'Хуурай арьс', 'icon' => '💧', 'color' => '#6B8CBA', 'bg' => '#EEF3FA', 'desc' => 'Татагдах, хальслах, хатуу мэдрэгдэх', 'tip' => 'Гиалурон хүчил, церамид агуулсан бүтээгдэхүүн'],
                ['type' => 'oily', 'label' => 'Тослог арьс', 'icon' => '✨', 'color' => '#5BA85A', 'bg' => '#EDF6ED', 'desc' => 'Гялтгануун, тослог, том нүхтэй', 'tip' => 'Oil-free, ниацинамид агуулсан бүтээгдэхүүн'],
                ['type' => 'combination', 'label' => 'Холимог арьс', 'icon' => '⚖️', 'color' => '#E8936A', 'bg' => '#FDF3ED', 'desc' => 'T-бүс тослог, хацар хуурай', 'tip' => 'Бүс тус бүрт тохирсон арчилгаа'],
                ['type' => 'normal', 'label' => 'Хэвийн арьс', 'icon' => '🌸', 'color' => '#9B7EC8', 'bg' => '#F3EEF8', 'desc' => 'Тэнцвэртэй, чийгтэй, цэвэрхэн', 'tip' => 'Хэвийн байдлыг хадгалах'],
                ['type' => 'sensitive', 'label' => 'Мэдрэмтгий арьс', 'icon' => '🌿', 'color' => '#E8726A', 'bg' => '#FDEEED', 'desc' => 'Улаарч, загатнаж, хурдан хариу үйлдэл', 'tip' => 'Гипоаллергени, спиртгүй бүтээгдэхүүн'],
            ];
            @endphp
            @foreach($skinTypes as $skin)
            <div class="col-lg-4 col-md-6">
                <div class="skin-type-card" style="--card-color: {{ $skin['color'] }}; --card-bg: {{ $skin['bg'] }}">
                    <div class="skin-type-icon">{{ $skin['icon'] }}</div>
                    <h5 class="fw-bold mb-2">{{ $skin['label'] }}</h5>
                    <p class="text-muted small mb-3">{{ $skin['desc'] }}</p>
                    <div class="skin-type-tip">
                        <i class="fa fa-lightbulb me-1"></i>{{ $skin['tip'] }}
                    </div>
                    <a href="{{ route('products.index', ['skin_type' => $skin['type']]) }}" class="skin-type-link mt-3">
                        Бүтээгдэхүүн үзэх →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="wave" aria-hidden="true">
            <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
                <path d="M0,34 C150,54 300,68 470,58 C650,48 770,20 950,28 C1080,34 1155,52 1200,46 L1200,70 L0,70 Z" fill="#6f3fc4"></path>
            </svg>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="section-padding how-section section-with-wave">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-badge">Хэрхэн ажилладаг вэ?</div>
            <h2 class="section-title">3 алхамаар эхэлнэ</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="how-card">
                    <div class="how-number">01</div>
                    <div class="how-icon">📋</div>
                    <h5>Тест өгөх</h5>
                    <p>8 асуултад хариулж арьсны төрлөө тодорхойлно</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="how-card">
                    <div class="how-number">02</div>
                    <div class="how-icon">🔍</div>
                    <h5>Үр дүн авах</h5>
                    <p>Арьсны төрлөөрөө тохирсон зөвлөгөө, бүтээгдэхүүн санал авна</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="how-card">
                    <div class="how-number">03</div>
                    <div class="how-icon">💎</div>
                    <h5>Арчилгаа эхлэх</h5>
                    <p>Зөв бүтээгдэхүүн, зөв дэглэмээр гоо арьстай болно</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('test.show') }}" class="btn btn-primary btn-lg">
                <i class="fa fa-play-circle me-2"></i>Одоо эхлэх
            </a>
        </div>
        <div class="wave" aria-hidden="true">
            <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
                <path d="M0,34 C150,54 300,68 470,58 C650,48 770,20 950,28 C1080,34 1155,52 1200,46 L1200,70 L0,70 Z" fill="#f4effb"></path>
            </svg>
        </div>
    </div>
</section>

<!-- ACNE INFO SECTION -->
<section class="section-padding home-section-lilac section-with-wave">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-badge">Батга мэдлэг</div>
            <h2 class="section-title">Батганы төрлүүдийг мэд</h2>
            <p class="section-subtitle">Батганы төрлийг зөв таних нь эмчилгээний эхний алхам</p>
        </div>
        <div class="row g-4">
            @php
            $acneTypes = [
                ['name' => 'Цагаан батга', 'icon' => '⚪', 'color' => '#e8e8d8', 'cause' => 'Нүх хаагдах, тос ихсэх', 'care' => 'Зөөлөн цэвэрлэгээ, BHA бүтээгдэхүүн'],
                ['name' => 'Хар батга', 'icon' => '⚫', 'color' => '#3a3a3a', 'cause' => 'Нээлттэй нүхэнд тос исэлдэх', 'care' => 'Тонер, clay mask, хөнгөн гуужуулалт'],
                ['name' => 'Папула', 'icon' => '🔴', 'color' => '#e74c3c', 'cause' => 'Үрэвсэлтэй улаан батга', 'care' => 'Арьс тайвшруулах, шахахгүй байх'],
                ['name' => 'Пустул', 'icon' => '🟡', 'color' => '#f39c12', 'cause' => 'Идтэй, үрэвсэл нэмэгдсэн батга', 'care' => 'Spot treatment, ариун цэвэр барих'],
                ['name' => 'Нодул', 'icon' => '🔵', 'color' => '#2980b9', 'cause' => 'Гүн үрэвсэл, өвдөлттэй товгор', 'care' => 'Мэргэжлийн эмчид үзүүлэх'],
                ['name' => 'Киста', 'icon' => '🟣', 'color' => '#8e44ad', 'cause' => 'Арьсны гүнд идтэй том голомт', 'care' => 'Өөрөө оролдохгүй, эмчийн эмчилгээ'],
            ];
            @endphp
            @foreach($acneTypes as $acne)
            <div class="col-lg-4 col-md-6">
                <div class="profile-card h-100" style="border-radius:24px">
                    <h5 class="fw-bold mb-3" style="color:var(--primary)">
                        <span style="color: {{ $acne['color'] }}">{{ $acne['icon'] }}</span> {{ $acne['name'] }}
                    </h5>
                    <p class="mb-2"><strong style="color:var(--primary)">Шалтгаан:</strong> {{ $acne['cause'] }}</p>
                    <p class="mb-0"><strong style="color:var(--primary)">Арчилгаа:</strong> {{ $acne['care'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="wave" aria-hidden="true">
            <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
                <path d="M0,35 C300,70 600,0 900,35 L1200,35 L1200,70 L0,70 Z" fill="#7a45d1"></path>
            </svg>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="cta-section">
    <div class="container text-center">
        <h2 class="cta-title">Арьсны тестээ өнөөдөр аваарай!</h2>
        <p class="cta-subtitle">Бүртгүүлж, арьсны дэлгэрэнгүй үр дүн, хувийн зөвлөгөөгөө хадгалаарай.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-semibold">
                <i class="fa fa-user-plus me-2"></i>Бүртгүүлэх
            </a>
            <a href="{{ route('test.show') }}" class="btn btn-outline-light btn-lg">
                Тест өгөх →
            </a>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .how-section {
        background: linear-gradient(135deg, #6f3fc4 0%, #7a45d1 48%, #9b73d8 100%) !important;
    }

    .how-card {
        background: rgba(255, 255, 255, 0.14) !important;
        border-color: rgba(255, 255, 255, 0.24) !important;
    }

    .how-card:hover {
        background: rgba(255, 255, 255, 0.2) !important;
        border-color: rgba(255, 255, 255, 0.42) !important;
    }

    .how-number {
        color: rgba(255, 255, 255, 0.32) !important;
    }

    .how-card p {
        color: rgba(255, 255, 255, 0.76) !important;
    }

    .cta-section {
        background: linear-gradient(135deg, #7a45d1 0%, #7f4ad4 48%, #5f3a9f 100%) !important;
    }

    .cta-section::before {
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.07'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") !important;
    }

    .cta-section .btn-light {
        color: #5f3a9f !important;
        border-color: #fff !important;
    }

    .cta-section .btn-outline-light:hover {
        color: #5f3a9f !important;
    }
</style>
@endpush
