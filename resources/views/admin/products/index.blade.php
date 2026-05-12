@extends('layouts.app')
@section('title', 'Бүтээгдэхүүн удирдах - Admin')

@section('content')
<div style="display:flex; min-height:100vh; padding-top:70px">
    <div class="admin-sidebar">
        <div class="admin-logo">✿ <span>Glow</span>MN Admin</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link"><i class="fa fa-gauge"></i> Самбар</a>
            <a href="{{ route('admin.products') }}" class="admin-nav-link active"><i class="fa fa-box"></i> Бүтээгдэхүүн</a>
            <a href="{{ route('admin.tips') }}" class="admin-nav-link"><i class="fa fa-lightbulb"></i> Зөвлөгөө</a>
            <a href="{{ route('admin.users') }}" class="admin-nav-link"><i class="fa fa-users"></i> Хэрэглэгчид</a>
            <hr style="border-color:rgba(255,255,255,0.1);margin:16px 24px">
            <a href="{{ route('home') }}" class="admin-nav-link"><i class="fa fa-globe"></i> Сайт руу очих</a>
        </nav>
    </div>
    <div class="admin-content" style="flex:1">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h4 class="fw-bold mb-0">🧴 Бүтээгдэхүүн ({{ $products->total() }})</h4>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-2"></i>Шинэ бүтээгдэхүүн
            </a>
        </div>

        <div class="admin-table">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Зураг</th>
                        <th>Нэр</th>
                        <th>Ангилал</th>
                        <th>Үнэ</th>
                        <th>Тохирох арьс</th>
                        <th>Идэвхтэй</th>
                        <th>Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                    <tr>
                        <td>
                            <img src="{{ $p->image_url }}" alt="{{ $p->name }}" style="width:52px;height:52px;object-fit:cover;border-radius:10px;background:var(--primary-light)">
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $p->name }}</div>
                            <div class="text-muted" style="font-size:12px">{{ $p->brand }}</div>
                        </td>
                        <td><span class="product-badge">{{ $p->category_label }}</span></td>
                        <td class="fw-semibold" style="color:var(--primary)">{{ number_format($p->price) }}₮</td>
                        <td>
                            <div class="skin-tags">
                                @foreach($p->suitable_for as $st)
                                <span class="skin-tag {{ $st }}" style="font-size:10px">{{ $st }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            @if($p->is_active)
                                <span style="background:#e8f5e9;color:#388e3c;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;display:inline-flex;align-items:center;gap:4px;white-space:nowrap">Тийм ✓</span>
                            @else
                                <span style="background:#fce4ec;color:#c62828;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;display:inline-flex;align-items:center;gap:4px;white-space:nowrap">Үгүй ✗</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.products.delete', $p) }}">
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
        <div class="d-flex justify-content-center mt-5 products-pagination">
            {{ $products->links() }}
        </div>
    </div>
</div>
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
