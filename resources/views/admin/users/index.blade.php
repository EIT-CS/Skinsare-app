@extends('layouts.app')
@section('title', 'Хэрэглэгчид - Admin')

@section('content')
<div style="display:flex; min-height:100vh; padding-top:70px">
    <div class="admin-sidebar">
        <div class="admin-logo">✿ <span>Glow</span>MN Admin</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link"><i class="fa fa-gauge"></i> Самбар</a>
            <a href="{{ route('admin.products') }}" class="admin-nav-link"><i class="fa fa-box"></i> Бүтээгдэхүүн</a>
            <a href="{{ route('admin.tips') }}" class="admin-nav-link"><i class="fa fa-lightbulb"></i> Зөвлөгөө</a>
            <a href="{{ route('admin.users') }}" class="admin-nav-link active"><i class="fa fa-users"></i> Хэрэглэгчид</a>
            <hr style="border-color:rgba(255,255,255,0.1);margin:16px 24px">
            <a href="{{ route('home') }}" class="admin-nav-link"><i class="fa fa-globe"></i> Сайт руу очих</a>
        </nav>
    </div>
    <div class="admin-content" style="flex:1">
        <h4 class="fw-bold mb-4">👥 Хэрэглэгчид ({{ $users->total() }})</h4>

        <div class="admin-table">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Хэрэглэгч</th>
                        <th>И-мэйл</th>
                        <th>Арьсны төрөл</th>
                        <th>Тест</th>
                        <th>Бүртгүүлсэн</th>
                        <th>Эрх</th>
                        <th>Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $u->avatar_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid var(--primary-light)">
                                <div class="fw-semibold">{{ $u->name }}</div>
                            </div>
                        </td>
                        <td style="font-size:13px">{{ $u->email }}</td>
                        <td>
                            @if($u->latestSkinTest)
                                <span>{{ $u->latestSkinTest->skin_type_icon }}</span>
                                <span style="font-size:13px">{{ $u->latestSkinTest->skin_type_label }}</span>
                            @else
                                <span class="text-muted" style="font-size:13px">—</span>
                            @endif
                        </td>
                        <td>
                            <span style="background:var(--primary-light);color:var(--primary);padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700">
                                {{ $u->skinTestResults->count() }}
                            </span>
                        </td>
                        <td class="text-muted" style="font-size:13px">{{ $u->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($u->is_admin)
                                <span style="background:#fff8e1;color:#f39c12;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700">
                                    👑 ADMIN
                                </span>
                            @else
                                <span style="background:var(--gray-1);color:var(--gray-3);padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600">
                                    Хэрэглэгч
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($u->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.toggle-admin', $u) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $u->is_admin ? 'btn-outline-warning' : 'btn-outline-primary' }}">
                                    {{ $u->is_admin ? 'Эрх хасах' : 'Admin болгох' }}
                                </button>
                            </form>
                            @else
                            <span class="text-muted" style="font-size:12px">Та өөрөө</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $users->links() }}</div>
    </div>
</div>
@endsection