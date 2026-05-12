@extends('layouts.app')
@section('title', 'Хяналтын самбар - GlowMN')

@section('content')
<div class="dashboard-section section-with-wave">
    <div class="container">

        <!-- Welcome Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="font-family: var(--font-display)">
                    Сайн байна уу, {{ $user->name }}! 👋
                </h2>
                <p class="text-muted mb-0">Таны арьс арчилгааны хяналтын самбар</p>
            </div>
            <a href="{{ route('test.show') }}" class="btn btn-primary">
                <i class="fa fa-flask me-2"></i>Шинэ тест өгөх
            </a>
        </div>

        <!-- Stats Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon pink">🧪</div>
                    <div>
                        <div class="stat-num">{{ $allTests->count() }}</div>
                        <div class="stat-label">Нийт тест</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon blue">📅</div>
                    <div>
                        <div class="stat-num">{{ (int) $user->created_at->diffInDays(now(), true) }}</div>
                        <div class="stat-label">Хоног бүртгэлтэй</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon green">✅</div>
                    <div>
                        <div class="stat-num">{{ $latestTest ? '✓' : '—' }}</div>
                        <div class="stat-label">Сүүлийн тест</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon purple">💎</div>
                    <div>
                        <div class="stat-num">{{ $products->count() }}</div>
                        <div class="stat-label">Санал болгосон</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Skin Type Result -->
            <div class="col-lg-4">
                @if($latestTest)
                <div class="result-skin-card mb-4">
                    <div style="font-size: 3rem; margin-bottom: 10px">{{ $latestTest->skin_type_icon }}</div>
                    <div style="font-size: 12px; opacity: 0.7; margin-bottom: 4px">ТАНЫ АРЬСНЫ ТӨРӨЛ</div>
                    <h3 style="font-weight: 700; font-size: 1.6rem; margin-bottom: 6px">{{ $latestTest->skin_type_label }}</h3>
                    <div style="opacity: 0.8; font-size: 13px">
                        {{ $latestTest->created_at->format('Y-m-d') }}-д тодорхойлсон
                    </div>
                    <a href="{{ route('products.index', ['skin_type' => $latestTest->skin_type]) }}"
                       class="btn btn-light btn-sm mt-3 fw-semibold">
                        Тохирох бүтээгдэхүүн →
                    </a>
                </div>

                <!-- Test History -->
                <div class="dashboard-card">
                    <h6 class="fw-bold mb-3">📋 Тестийн түүх</h6>
                    @foreach($allTests->take(5) as $test)
                    <div class="history-item">
                        <div class="d-flex align-items-center gap-2">
                            <span>{{ $test->skin_type_icon }}</span>
                            <div>
                                <div class="fw-semibold" style="font-size:13px">{{ $test->skin_type_label }}</div>
                                <div style="font-size:11px; color: var(--gray-3)">{{ $test->created_at->format('Y-m-d H:i') }}</div>
                            </div>
                        </div>
                        <i class="fa fa-chevron-right" style="font-size:12px; color: var(--gray-3)"></i>
                    </div>
                    @endforeach
                    @if($allTests->count() === 0)
                        <div class="text-center text-muted py-3" style="font-size:14px">
                            Тестийн түүх байхгүй
                        </div>
                    @endif
                </div>

                @else
                <!-- No test yet -->
                <div class="dashboard-card text-center py-5">
                    <div style="font-size: 3.5rem; margin-bottom: 16px">🔬</div>
                    <h6 class="fw-bold mb-2">Арьсны тест өгөөгүй байна</h6>
                    <p class="text-muted small mb-3">Тест өгснөөр арьсны төрлөөрөө тохирсон зөвлөгөө авна уу</p>
                    <a href="{{ route('test.show') }}" class="btn btn-primary btn-sm">
                        Тест өгөх →
                    </a>
                </div>
                @endif
            </div>

            <!-- Right column -->
            <div class="col-lg-8">
                <!-- Recommended Products -->
                @if($products->count())
                <div class="dashboard-card mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="fa fa-star me-2" style="color:var(--primary)"></i>Санал болгох бүтээгдэхүүн</h5>
                        <a href="{{ route('products.index', ['skin_type' => $latestTest?->skin_type]) }}" style="font-size:13px; color:var(--primary)">Бүгдийг харах →</a>
                    </div>
                    <div class="row g-3">
                        @foreach($products->take(4) as $product)
                        <div class="col-md-6">
                            <div style="display:flex; gap:12px; padding:14px; border:1.5px solid var(--gray-2); border-radius:12px; transition:var(--transition)" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--gray-2)'">
                                <div style="width:52px;height:52px;background:var(--primary-light);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0">🧴</div>
                                <div style="min-width:0">
                                    <div style="font-size:11px;font-weight:700;color:var(--primary);background:var(--primary-light);padding:2px 8px;border-radius:20px;display:inline-block;margin-bottom:4px">{{ $product->category_label }}</div>
                                    <div style="font-weight:700;font-size:13px;line-height:1.3;margin-bottom:3px">{{ Str::limit($product->name, 36) }}</div>
                                    <div style="font-weight:700;color:var(--primary);font-size:14px">{{ number_format($product->price) }}₮</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tips -->
                @if($tips->count())
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="fa fa-lightbulb me-2" style="color:var(--primary)"></i>Зөвлөгөө</h5>
                        <a href="{{ route('tips.index', ['skin_type' => $latestTest?->skin_type]) }}" style="font-size:13px; color:var(--primary)">Бүгдийг харах →</a>
                    </div>
                    <div class="row g-3">
                        @foreach($tips->take(2) as $tip)
                        <div class="col-md-6">
                            <div style="padding:16px;background:var(--gray-1);border-radius:12px;height:100%">
                                <span style="font-size:1.6rem;display:block;margin-bottom:8px">{{ $tip->icon ?? '💡' }}</span>
                                <div style="font-size:11px;font-weight:700;color:var(--primary);background:var(--primary-light);padding:2px 8px;border-radius:20px;display:inline-block;margin-bottom:8px">{{ $tip->category_label }}</div>
                                <div style="font-weight:700;font-size:14px;margin-bottom:6px">{{ $tip->title }}</div>
                                <div style="font-size:13px;color:var(--gray-3);line-height:1.6">{{ Str::limit(strip_tags($tip->content), 100) }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!$latestTest)
                <div class="dashboard-card text-center py-5" style="background: linear-gradient(135deg, var(--primary-light), #f0f4ff)">
                    <div style="font-size:3rem;margin-bottom:12px">✨</div>
                    <h5 class="fw-bold">Арьсны тест өгснөөр...</h5>
                    <p class="text-muted">Арьсны төрлөөрөө тохирсон зөвлөгөө болон бүтээгдэхүүний санал автоматаар гарна</p>
                    <a href="{{ route('test.show') }}" class="btn btn-primary">Тест өгөх →</a>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="wave" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
            <path d="M0,35 C300,70 600,0 900,35 L1200,35 L1200,70 L0,70 Z" fill="#5f3a9f"></path>
        </svg>
    </div>
</div>
@endsection
