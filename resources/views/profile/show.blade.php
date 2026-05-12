@extends('layouts.app')
@section('title', 'Профайл - GlowMN')

@section('content')
<!-- Profile Header -->
<div class="profile-header section-with-wave">
    <div class="container">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="profile-avatar-lg">
            <div>
                <h2 class="fw-bold mb-1">{{ $user->name }}</h2>
                <p style="opacity:0.7; margin-bottom:6px">{{ $user->email }}</p>
                @if($user->latestSkinTest)
                <span class="profile-skin-chip">
                    {{ $user->latestSkinTest->skin_type_icon }} {{ $user->latestSkinTest->skin_type_label }}
                </span>
                @endif
            </div>
            <div class="ms-auto">
                <a href="{{ route('profile.edit') }}" class="btn profile-edit-btn btn-sm fw-semibold">
                    <i class="fa fa-edit me-1"></i>Засах
                </a>
            </div>
        </div>
    </div>
    <div class="wave" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
            <path d="M0,34 C150,54 300,68 470,58 C650,48 770,20 950,28 C1080,34 1155,52 1200,46 L1200,70 L0,70 Z" fill="#f8f9fa"></path>
        </svg>
    </div>
</div>

<section class="section-padding section-with-wave" style="background: var(--gray-1); padding-top: 40px">
    <div class="container">
        <div class="row g-4">
            <!-- Info Card -->
            <div class="col-lg-4">
                <div class="profile-card">
                    <h6 class="fw-bold mb-4"><i class="fa fa-user me-2" style="color:var(--primary)"></i>Хувийн мэдээлэл</h6>
                    @php
                    $info = [
                        ['icon' => 'fa-envelope', 'label' => 'И-мэйл', 'val' => $user->email],
                        ['icon' => 'fa-clock', 'label' => 'Бүртгүүлсэн', 'val' => $user->created_at->format('Y-m-d')],
                    ];
                    @endphp
                    @foreach($info as $item)
                    <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="{{ !$loop->last ? 'border-bottom: 1px solid var(--gray-2)' : '' }}">
                        <div style="width:36px;height:36px;background:var(--primary-light);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fa {{ $item['icon'] }}" style="color:var(--primary); font-size:14px"></i>
                        </div>
                        <div>
                            <div style="font-size:11px;color:var(--gray-3);font-weight:600;text-transform:uppercase;letter-spacing:0.5px">{{ $item['label'] }}</div>
                            <div style="font-size:14px;font-weight:600">{{ $item['val'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- History -->
            <div class="col-lg-8">
                <div class="profile-card">
                    <h6 class="fw-bold mb-4"><i class="fa fa-history me-2" style="color:var(--primary)"></i>Тестийн түүх ({{ $history->count() }})</h6>
                    @if($history->count())
                    <div class="table-responsive">
                        <table class="table table-hover" style="font-size:14px">
                            <thead style="background: var(--gray-1)">
                                <tr>
                                    <th class="fw-semibold">Арьсны төрөл</th>
                                    <th class="fw-semibold">Хуурай</th>
                                    <th class="fw-semibold">Тослог</th>
                                    <th class="fw-semibold">Холимог</th>
                                    <th class="fw-semibold">Мэдрэмтгий</th>
                                    <th class="fw-semibold">Огноо</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $h)
                                <tr>
                                    <td>
                                        <span style="font-size:1.1rem">{{ $h->skin_type_icon }}</span>
                                        <span class="fw-semibold ms-1">{{ $h->skin_type_label }}</span>
                                    </td>
                                    <td>{{ $h->score_dry }}</td>
                                    <td>{{ $h->score_oily }}</td>
                                    <td>{{ $h->score_combination }}</td>
                                    <td>{{ $h->score_sensitive }}</td>
                                    <td class="text-muted">{{ $h->created_at->format('Y-m-d') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty-state py-4">
                        <span class="empty-state-icon">🧪</span>
                        <p>Тестийн түүх байхгүй байна</p>
                        <a href="{{ route('test.show') }}" class="btn btn-primary btn-sm">Тест өгөх</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="wave profile-footer-wave" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
            <path d="M0,34 C150,54 300,68 470,58 C650,48 770,20 950,28 C1080,34 1155,52 1200,46 L1200,70 L0,70 Z" fill="#5f3a9f"></path>
        </svg>
    </div>
</section>
@endsection

@push('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #5f3a9f 0%, #7a45d1 58%, #b68be8 100%) !important;
        padding-bottom: 52px !important;
    }

    .profile-header .wave svg {
        height: 86px !important;
    }

    .profile-footer-wave svg {
        height: 92px !important;
    }

    .profile-avatar-lg {
        border-color: rgba(255, 255, 255, 0.92) !important;
        box-shadow: 0 14px 34px rgba(74, 42, 130, 0.22) !important;
    }

    .profile-edit-btn {
        background: #fff !important;
        color: #7a45d1 !important;
        border: 1px solid rgba(255, 255, 255, 0.82) !important;
        border-radius: 999px !important;
        padding: 8px 16px !important;
        box-shadow: 0 8px 18px rgba(74, 42, 130, 0.18) !important;
    }

    .profile-edit-btn:hover {
        background: #f4ecff !important;
        color: #6330b8 !important;
    }
</style>
@endpush
