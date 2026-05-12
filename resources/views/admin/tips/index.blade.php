@extends('layouts.app')
@section('title', 'Зөвлөгөө удирдах - Admin')

@section('content')
<div style="display:flex; min-height:100vh; padding-top:70px">
    <div class="admin-sidebar">
        <div class="admin-logo">✿ <span>Glow</span>MN Admin</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link"><i class="fa fa-gauge"></i> Самбар</a>
            <a href="{{ route('admin.products') }}" class="admin-nav-link"><i class="fa fa-box"></i> Бүтээгдэхүүн</a>
            <a href="{{ route('admin.tips') }}" class="admin-nav-link active"><i class="fa fa-lightbulb"></i> Зөвлөгөө</a>
            <a href="{{ route('admin.users') }}" class="admin-nav-link"><i class="fa fa-users"></i> Хэрэглэгчид</a>
            <hr style="border-color:rgba(255,255,255,0.1);margin:16px 24px">
            <a href="{{ route('home') }}" class="admin-nav-link"><i class="fa fa-globe"></i> Сайт руу очих</a>
        </nav>
    </div>
    
    <div class="admin-content" style="flex:1">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h4 class="fw-bold mb-0">💡 Зөвлөгөө ({{ $tips->total() }})</h4>
            <a href="{{ route('admin.tips.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-2"></i>Шинэ зөвлөгөө
            </a>
        </div>

        <div class="admin-table">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Гарчиг</th>
                        <th>Ангилал</th>
                        <th>Тохирох арьс</th>
                        <th>Идэвхтэй</th>
                        <th>Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tips as $tip)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span>{{ $tip->icon ?? '💡' }}</span>
                                <div>
                                    <div class="fw-semibold">{{ $tip->title }}</div>
                                    <div class="text-muted" style="font-size:12px">{{ Str::limit($tip->content, 60) }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="product-badge">{{ $tip->category_label }}</span></td>
                        <td>
                            <div class="skin-tags">
                                @foreach($tip->suitable_for as $st)
                                <span class="skin-tag {{ $st }}" style="font-size:10px">{{ $st }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            @if($tip->is_active)
                                <span style="background:#e8f5e9;color:#388e3c;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600">✓ Тийм</span>
                            @else
                                <span style="background:#fce4ec;color:#c62828;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600">✗ Үгүй</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.tips.edit', $tip) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.tips.delete', $tip) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-delete-confirm d-inline-flex align-items-center justify-content-center" style="width:58px;height:39px;padding:0">
                                        <i class="fa fa-trash" style="font-size:18px"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $tips->links() }}</div>
    </div>
</div>
@endsection
