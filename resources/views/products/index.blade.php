@extends('layouts.app')
@section('title', 'Бүтээгдэхүүн - GlowMN')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container page-header-content">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Нүүр</a></li>
                <li class="breadcrumb-item active">Бүтээгдэхүүн</li>
            </ol>
        </nav>
        <h1>🧴 Бүтээгдэхүүн</h1>
        <p>Арьсны төрлөөрөө тохирсон бүтээгдэхүүнийг олоорой</p>
    </div>
</div>

<section class="section-padding section-with-wave" style="background: var(--gray-1); padding-top: 40px">
    <div class="container">

        <!-- Filter Bar -->
        <div class="filter-bar">
            <span class="fw-semibold me-2" style="font-size:14px; white-space:nowrap">
                <i class="fa fa-filter me-1" style="color:var(--primary)"></i>Арьсны төрөл:
            </span>
            <button class="filter-btn pill {{ !$skinType ? 'active' : '' }}" data-filter="" data-filter-key="skin_type">Бүгд</button>
            <button class="filter-btn pill {{ $skinType === 'dry' ? 'active' : '' }}" data-filter="dry" data-filter-key="skin_type">💧 Хуурай</button>
            <button class="filter-btn pill {{ $skinType === 'oily' ? 'active' : '' }}" data-filter="oily" data-filter-key="skin_type">✨ Тослог</button>
            <button class="filter-btn pill {{ $skinType === 'combination' ? 'active' : '' }}" data-filter="combination" data-filter-key="skin_type">⚖️ Холимог</button>
            <button class="filter-btn pill {{ $skinType === 'normal' ? 'active' : '' }}" data-filter="normal" data-filter-key="skin_type">🌸 Хэвийн</button>
            <button class="filter-btn pill {{ $skinType === 'sensitive' ? 'active' : '' }}" data-filter="sensitive" data-filter-key="skin_type">🌿 Мэдрэмтгий</button>
        </div>

        <!-- Category Filter -->
        <div class="filter-bar" style="padding: 14px 24px">
            <span class="fw-semibold me-2" style="font-size:14px; white-space:nowrap">
                <i class="fa fa-tag me-1" style="color:var(--primary)"></i>Ангилал:
            </span>
            <button class="filter-btn pill {{ !$category ? 'active' : '' }}" data-filter="" data-filter-key="category">Бүгд</button>
            @foreach(['cleanser' => 'Цэвэрлэгч', 'toner' => 'Тонер', 'moisturizer' => 'Чийгшүүлэгч', 'serum' => 'Серум', 'sunscreen' => 'Нарнаас хамгаалах', 'mask' => 'Маск', 'spot' => 'Батга эмчлэгч'] as $cat => $catLabel)
            <button class="filter-btn pill {{ $category === $cat ? 'active' : '' }}" data-filter="{{ $cat }}" data-filter-key="category">{{ $catLabel }}</button>
            @endforeach
        </div>

        <!-- Product Grid -->
        @if($products->count())
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up">
                <div class="product-card">
                    <div class="product-img-wrap">
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        @else
                            <span class="product-img-placeholder">🧴</span>
                        @endif
                    </div>
                    <div class="product-body">
                        <div class="product-badge">{{ $product->category_label }}</div>
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-brand">{{ $product->brand }}</div>
                        <div class="product-stars mb-1">
                            @for($i = 0; $i < 5; $i++)
                                {{ $i < $product->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                        <div class="product-desc">{{ Str::limit($product->description, 80) }}</div>
                        <div class="skin-tags">
                            @foreach($product->suitable_for as $st)
                            @php
                            $stLabels = ['dry' => 'Хуурай', 'oily' => 'Тослог', 'combination' => 'Холимог', 'normal' => 'Хэвийн', 'sensitive' => 'Мэдрэмтгий'];
                            @endphp
                            <span class="skin-tag {{ $st }}">{{ $stLabels[$st] ?? $st }}</span>
                            @endforeach
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-3">
                            <div class="product-price">{{ number_format($product->price) }}₮</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5 products-pagination">
            {{ $products->withQueryString()->links() }}
        </div>

        @else
        <div class="empty-state">
            <span class="empty-state-icon">🔍</span>
            <h5 class="fw-bold mb-2">Бүтээгдэхүүн олдсонгүй</h5>
            <p class="text-muted">Шүүлтүүрийг өөрчлөөд дахин туршаарай</p>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary mt-2">Бүгдийг харах</a>
        </div>
        @endif
    </div>
    <div class="wave" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
            <path d="M0,35 C300,70 600,0 900,35 L1200,35 L1200,70 L0,70 Z" fill="#5f3a9f"></path>
        </svg>
    </div>
</section>
@endsection

@push('styles')
<style>
    .products-pagination nav[role="navigation"] > div:first-child {
        display: none;
    }

    .products-pagination nav[role="navigation"] > div:last-child > div:first-child {
        display: none;
    }

    .products-pagination nav[role="navigation"] > div:last-child > div:last-child {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .products-pagination .pagination {
        display: flex;
        gap: 14px;
        align-items: center;
        margin: 0;
    }

    .products-pagination .page-item {
        margin: 0;
    }

    .products-pagination .page-link,
    .products-pagination nav[role="navigation"] a,
    .products-pagination nav[role="navigation"] span[aria-current="page"] span,
    .products-pagination nav[role="navigation"] span[aria-disabled="true"] span {
        width: 68px;
        height: 68px;
        border-radius: 999px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 30px;
        text-decoration: none;
        background: #fff;
        color: var(--primary);
        box-shadow: none;
        position: relative;
        cursor: pointer;
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .products-pagination .page-link::after,
    .products-pagination nav[role="navigation"] a::after,
    .products-pagination nav[role="navigation"] span[aria-current="page"] span::after,
    .products-pagination nav[role="navigation"] span[aria-disabled="true"] span::after {
        content: "";
        position: absolute;
        left: 10px;
        right: 10px;
        bottom: -4px;
        height: 4px;
        border-radius: 999px;
        background: #f48fb1;
        opacity: 0;
        transform: scaleX(0.55);
        transition: opacity 0.2s ease, transform 0.2s ease, height 0.2s ease;
    }

    .products-pagination .page-item.active .page-link,
    .products-pagination nav[role="navigation"] span[aria-current="page"] span {
        background: var(--primary);
        color: #fff;
    }

    .products-pagination nav[role="navigation"] span[aria-disabled="true"] span {
        opacity: 0.45;
    }

    .products-pagination nav[role="navigation"] svg {
        width: 24px;
        height: 24px;
    }

    .products-pagination .page-link:hover,
    .products-pagination nav[role="navigation"] a:hover {
        transform: translateY(-4px) scale(1.03) !important;
        color: var(--primary-dark) !important;
        box-shadow: none !important;
        background: #f6f0ff !important;
    }

    .products-pagination nav[role="navigation"] a:hover::after,
    .products-pagination .page-link:hover::after {
        background: #ff7ea8;
        height: 5px;
        opacity: 1;
        transform: scaleX(1);
    }
</style>
@endpush
