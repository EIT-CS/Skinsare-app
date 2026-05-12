@extends('layouts.app')
@section('title', 'Админ - GlowMN')

@section('content')
<div style="display:flex; min-height:100vh; padding-top:70px">
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="admin-logo">✿ <span>Glow</span>MN Admin</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-gauge"></i> Самбар
            </a>
            <a href="{{ route('admin.products') }}" class="admin-nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <i class="fa fa-box"></i> Бүтээгдэхүүн
            </a>
            <a href="{{ route('admin.tips') }}" class="admin-nav-link {{ request()->routeIs('admin.tips*') ? 'active' : '' }}">
                <i class="fa fa-lightbulb"></i> Зөвлөгөө
            </a>
            <a href="{{ route('admin.users') }}" class="admin-nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fa fa-users"></i> Хэрэглэгчид
            </a>
            <hr style="border-color: rgba(255,255,255,0.1); margin: 16px 24px">
            <a href="{{ route('home') }}" class="admin-nav-link">
                <i class="fa fa-globe"></i> Сайт руу очих
            </a>
        </nav>
    </div>

    <!-- Content -->
    <div class="admin-content" style="flex:1">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">📊 Нийт статистик</h4>
            <span class="text-muted" style="font-size:14px">{{ now()->format('Y-m-d') }}</span>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            @php
            $statItems = [
                ['label' => 'Хэрэглэгч', 'val' => $stats['users'], 'icon' => '👤', 'color' => '#6B8CBA'],
                ['label' => 'Тест', 'val' => $stats['tests'], 'icon' => '🧪', 'color' => '#E8726A'],
                ['label' => 'Бүтээгдэхүүн', 'val' => $stats['products'], 'icon' => '🧴', 'color' => '#5BA85A'],
                ['label' => 'Зөвлөгөө', 'val' => $stats['tips'], 'icon' => '💡', 'color' => '#E8936A'],
            ];
            @endphp
            @foreach($statItems as $s)
            <div class="col-md-3 col-6">
                <div class="admin-stat-card">
                    <div style="font-size:2rem; margin-bottom:8px">{{ $s['icon'] }}</div>
                    <div class="admin-stat-num" style="color: {{ $s['color'] }}">{{ $s['val'] }}</div>
                    <div class="admin-stat-label">{{ $s['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row g-4">
            <!-- Skin type distribution -->
            <div class="col-lg-6">
                <div style="background:white; border-radius:var(--radius-lg); padding:24px; box-shadow:var(--shadow-sm)">
                    <h6 class="fw-bold mb-4">🔬 Арьсны төрлийн тархалт</h6>
                    @php
                    $typeLabels = ['dry' => ['Хуурай', '#6B8CBA'], 'oily' => ['Тослог', '#5BA85A'], 'combination' => ['Холимог', '#E8936A'], 'normal' => ['Хэвийн', '#9B7EC8'], 'sensitive' => ['Мэдрэмтгий', '#E8726A']];
                    $totalTests = $skinStats->sum();
                    @endphp
                    @foreach($typeLabels as $type => [$name, $color])
                    @php $cnt = $skinStats[$type] ?? 0; $pct = $totalTests > 0 ? round($cnt / $totalTests * 100) : 0; @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1" style="font-size:13px">
                            <span class="fw-semibold">{{ $name }}</span>
                            <span style="color:{{ $color }}; font-weight:700">{{ $cnt }} ({{ $pct }}%)</span>
                        </div>
                        <div style="height:8px;background:var(--gray-2);border-radius:30px;overflow:hidden">
                            <div style="height:100%;width:{{ $pct }}%;background:{{ $color }};border-radius:30px;transition:width 1s ease"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Users -->
            <div class="col-lg-6">
                <div style="background:white; border-radius:var(--radius-lg); padding:24px; box-shadow:var(--shadow-sm)">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0">👤 Сүүлийн хэрэглэгчид</h6>
                        <a href="{{ route('admin.users') }}" style="font-size:13px;color:var(--primary)">Бүгд →</a>
                    </div>
                    @foreach($recentUsers as $u)
                    <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="{{ !$loop->last ? 'border-bottom:1px solid var(--gray-2)' : '' }}">
                        <img src="{{ $u->avatar_url }}" style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid var(--primary-light)">
                        <div style="flex:1;min-width:0">
                            <div style="font-weight:600;font-size:14px">{{ $u->name }}</div>
                            <div style="font-size:12px;color:var(--gray-3)">{{ $u->email }}</div>
                        </div>
                        @if($u->is_admin)
                        <span style="background:#fff8e1;color:#f39c12;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700">ADMIN</span>
                        @endif
                        <span style="font-size:11px;color:var(--gray-3)">{{ $u->created_at->format('m-d') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection