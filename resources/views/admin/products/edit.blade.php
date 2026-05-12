@extends('layouts.app')
@section('title', 'Бүтээгдэхүүн засах - Admin')

@section('content')
<div style="display:flex; min-height:100vh; padding-top:70px">
    <div class="admin-sidebar">
        <div class="admin-logo">✿ <span>Glow</span>MN Admin</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link"><i class="fa fa-gauge"></i> Самбар</a>
            <a href="{{ route('admin.products') }}" class="admin-nav-link active"><i class="fa fa-box"></i> Бүтээгдэхүүн</a>
            <a href="{{ route('admin.tips') }}" class="admin-nav-link"><i class="fa fa-lightbulb"></i> Зөвлөгөө</a>
            <a href="{{ route('admin.users') }}" class="admin-nav-link"><i class="fa fa-users"></i> Хэрэглэгчид</a>
        </nav>
    </div>
    <div class="admin-content" style="flex:1">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left"></i></a>
            <h4 class="fw-bold mb-0">✏️ Бүтээгдэхүүн засах</h4>
        </div>

        @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-3">
            <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <div style="background:white; border-radius:var(--radius-lg); padding:32px; box-shadow:var(--shadow-sm)">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Бүтээгдэхүүний нэр *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Брэнд</label>
                        <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Тайлбар *</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Үнэ (₮) *</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" step="100" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Ангилал *</label>
                        <select name="category" class="form-select" required>
                            @foreach(['cleanser' => 'Цэвэрлэгч', 'toner' => 'Тонер', 'moisturizer' => 'Чийгшүүлэгч', 'serum' => 'Серум', 'sunscreen' => 'Нарнаас хамгаалах', 'mask' => 'Маск', 'spot' => 'Батга эмчлэгч', 'eye_cream' => 'Нүдний тос'] as $val => $label)
                            <option value="{{ $val }}" {{ old('category', $product->category) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Үнэлгээ</label>
                        <select name="rating" class="form-select">
                            @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating', $product->rating) == $i ? 'selected' : '' }}>{{ str_repeat('★', $i) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Тохирох арьсны төрөл *</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach(['dry' => '💧 Хуурай', 'oily' => '✨ Тослог', 'combination' => '⚖️ Холимог', 'normal' => '🌸 Хэвийн', 'sensitive' => '🌿 Мэдрэмтгий'] as $val => $label)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="suitable_for[]"
                                    value="{{ $val }}" id="st_{{ $val }}"
                                    {{ in_array($val, old('suitable_for', $product->suitable_for ?? [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="st_{{ $val }}">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Зураг солих</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ $product->image_url }}" style="width:80px;height:80px;object-fit:cover;border-radius:10px">
                                <span class="text-muted ms-2" style="font-size:12px">Одоогийн зураг</span>
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <input type="url" name="image_url" class="form-control mt-2" value="{{ old('image_url', str_starts_with($product->image ?? '', 'http') ? $product->image : '') }}" placeholder="https://example.com/product.jpg">
                        <div class="text-muted mt-1" style="font-size:12px">Файл эсвэл URL оруулж болно. Файл сонговол түүнийг ашиглана.</div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                                {{ $product->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">Идэвхтэй</label>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary px-5 py-2">
                            <i class="fa fa-save me-2"></i>Хадгалах
                        </button>
                        <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary ms-2 px-5 py-2">Болих</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
