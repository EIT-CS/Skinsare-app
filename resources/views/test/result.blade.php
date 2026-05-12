@extends('layouts.app')
@section('title', 'Тестийн үр дүн - GlowMN')

@php
$labels = [
    'dry'         => ['label' => 'Хуурай арьс',       'icon' => '💧', 'color' => '#6B8CBA', 'bg' => '#EEF3FA'],
    'oily'        => ['label' => 'Тослог арьс',      'icon' => '✨', 'color' => '#5BA85A', 'bg' => '#EDF6ED'],
    'combination' => ['label' => 'Холимог арьс',      'icon' => '⚖️', 'color' => '#E8936A', 'bg' => '#FDF3ED'],
    'normal'      => ['label' => 'Хэвийн арьс',        'icon' => '🌸', 'color' => '#9B7EC8', 'bg' => '#F3EEF8'],
    'sensitive'   => ['label' => 'Мэдрэмтгий арьс',   'icon' => '🌿', 'color' => '#E8726A', 'bg' => '#FDEEED'],
];
$current = $labels[$dominantType] ?? $labels['normal'];
$totalScore = array_sum($scores);
$descriptions = [
    'dry'         => 'Таны арьс хуурай байна. Чийглэг байдлыг хадгалах нь хамгийн чухал. Церамид, гиалурон хүчил агуулсан бүтээгдэхүүн ашигла.',
    'oily'        => 'Таны арьс тосорхог байна. Тосны ялгаралтыг зохицуулах, нүхийг цэвэрлэх нь гол зорилго. Oil-free, нианиамид агуулсан бүтээгдэхүүн сонго.',
    'combination' => 'Таны арьс хосолмол байна. T-бүс тосорхог, хацар хуурай. Бүс тус бүрт тохирсон арчилгаа хэрэглэ.',
    'normal'      => 'Таны арьс хэвийн, тэнцвэртэй байна. Энэ тэнцвэрийг хадгалахад анхаарлаа хандуул.',
    'sensitive'   => 'Таны арьс мэдрэмтгий байна. Зөөлөн, гипоаллергени бүтээгдэхүүн ашигла. Шинэ бүтээгдэхүүн туршихдаа болгоомжтой байгаарай.',
];
@endphp

@section('content')

<!-- Result Hero -->
<section class="result-hero section-with-wave">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="result-badge-circle"
                     style="background: {{ $current['bg'] }}; border-color: {{ $current['color'] }}; color: {{ $current['color'] }}">
                    {{ $current['icon'] }}
                </div>
                <div class="section-badge mb-2">Тестийн үр дүн</div>
                <h1 class="section-title">{{ $current['label'] }}</h1>
                <p class="text-muted mx-auto" style="max-width:500px; font-size:1.05rem;">
                    {{ $descriptions[$dominantType] ?? '' }}
                </p>

                @auth
                    @if($result)
                        <div class="alert alert-success d-inline-flex align-items-center gap-2 mt-3 rounded-pill px-4" style="font-size:14px">
                            <i class="fa fa-check-circle"></i> Үр дүн амжилттай хадгалагдлаа
                        </div>
                    @endif
                @else
                    <div class="alert result-save-notice d-inline-flex align-items-center gap-2 mt-3 rounded-pill px-4" style="font-size:14px">
                        <i class="fa fa-info-circle"></i>
                        <a href="{{ route('register') }}" class="fw-semibold">Бүртгүүлснээр</a>&nbsp;үр дүнгээ хадгалах боломжтой
                    </div>
                @endauth
            </div>
        </div>
    </div>
    <div class="wave" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
            <path d="M0,35 C300,70 600,0 900,35 L1200,35 L1200,70 L0,70 Z" fill="#f8f9fa"></path>
        </svg>
    </div>
</section>

<section class="section-padding section-with-wave" style="background: var(--gray-1)">
    <div class="container">
        <div class="row g-4">

            <!-- Score Breakdown -->
            <div class="col-lg-4">
                <div class="dashboard-card h-100">
                    <h5 class="fw-bold mb-4"><i class="fa fa-chart-bar me-2" style="color:var(--primary)"></i>Оноо</h5>
                    @php
                    $scoreLabels = ['dry' => ['Хуурай', '#6B8CBA'], 'oily' => ['Тослог', '#5BA85A'], 'combination' => ['Холимог', '#E8936A'], 'sensitive' => ['Мэдрэмтгий', '#E8726A']];
                    $max = max($scores) ?: 1;
                    @endphp
                    @foreach($scoreLabels as $type => [$name, $color])
                    <div class="score-bar-wrap">
                        <div class="score-bar-label">
                            <span class="fw-semibold" style="font-size:14px">{{ $name }}</span>
                            <span style="color:{{ $color }}; font-weight:700">{{ $scores[$type] ?? 0 }}</span>
                        </div>
                        <div class="score-bar">
                            <div class="score-bar-fill" style="background:{{ $color }}; width:0"
                                 data-width="{{ $max > 0 ? round((($scores[$type] ?? 0) / $max) * 100) : 0 }}">
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="mt-4 p-3 rounded-3" style="background: {{ $current['bg'] }}; border: 1px solid {{ $current['color'] }}20">
                        <div class="fw-bold mb-1" style="color: {{ $current['color'] }}">
                            {{ $current['icon'] }} {{ $current['label'] }}
                        </div>
                        <div style="font-size:13px; color: var(--gray-3)">Таны арьсны үндсэн төрөл</div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="col-lg-8">
                @if($products->count())
                <div class="dashboard-card">
                    <h5 class="fw-bold mb-4"><i class="fa fa-star me-2" style="color:var(--primary)"></i>Санал болгох бүтээгдэхүүн</h5>
                    <div class="row g-3">
                        @foreach($products->take(4) as $product)
                        <div class="col-md-6">
                            <div class="product-card d-flex gap-3 p-3" style="border-radius: 12px; height: auto">
                                <div style="width:60px; height:60px; background:var(--primary-light); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1.6rem">
                                    🧴
                                </div>
                                <div>
                                    <div class="product-badge">{{ $product->category_label }}</div>
                                    <div class="fw-bold" style="font-size:14px; line-height:1.3">{{ $product->name }}</div>
                                    <div class="text-muted" style="font-size:12px">{{ $product->brand }}</div>
                                    <div class="fw-bold mt-1" style="color:var(--primary); font-size:15px">{{ number_format($product->price) }}₮</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-end mt-3">
                        <a href="{{ route('products.index', ['skin_type' => $dominantType]) }}" class="btn btn-outline-primary btn-sm">
                            Бүгдийг харах →
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Tips -->
            @if($tips->count())
            <div class="col-12">
                <h4 class="fw-bold mb-4"><i class="fa fa-lightbulb me-2" style="color:var(--primary)"></i>Таны арьсанд тохирсон зөвлөгөө</h4>
                <div class="row g-3">
                    @foreach($tips as $tip)
                    <div class="col-lg-6">
                        <div class="tip-card">
                            <span class="tip-icon">{{ $tip->icon ?? '💡' }}</span>
                            <div class="tip-category-badge">{{ $tip->category_label }}</div>
                            <div class="tip-title">{{ $tip->title }}</div>
                            <div class="tip-content">{!! nl2br(e($tip->content)) !!}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="col-12">
                <div class="dashboard-card text-center">
                    <h5 class="fw-bold mb-3">Дараагийн алхам</h5>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('products.index', ['skin_type' => $dominantType]) }}" class="btn btn-primary">
                            <i class="fa fa-shopping-bag me-2"></i>Бүтээгдэхүүн харах
                        </a>
                        <a href="{{ route('tips.index', ['skin_type' => $dominantType]) }}" class="btn btn-outline-primary">
                            <i class="fa fa-book me-2"></i>Зөвлөгөө уншиx
                        </a>
                        <a href="{{ route('test.show') }}" class="btn btn-outline-secondary">
                            <i class="fa fa-redo me-2"></i>Дахин тест өгөх
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-dark">
                                <i class="fa fa-gauge me-2"></i>Самбар руу очих
                            </a>
                        @endauth
                    </div>
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
