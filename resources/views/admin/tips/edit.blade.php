@extends('layouts.app')
@section('title', 'Зөвлөгөө нэмэх - Admin')

@section('content')
<div style="display:flex; min-height:100vh; padding-top:70px">
    <div class="admin-sidebar">
        <div class="admin-logo">✿ <span>Glow</span>MN Admin</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link"><i class="fa fa-gauge"></i> Самбар</a>
            <a href="{{ route('admin.products') }}" class="admin-nav-link"><i class="fa fa-box"></i> Бүтээгдэхүүн</a>
            <a href="{{ route('admin.tips') }}" class="admin-nav-link active"><i class="fa fa-lightbulb"></i> Зөвлөгөө</a>
            <a href="{{ route('admin.users') }}" class="admin-nav-link"><i class="fa fa-users"></i> Хэрэглэгчид</a>
        </nav>
    </div>
    <div class="admin-content" style="flex:1">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('admin.tips') }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left"></i></a>
            <h4 class="fw-bold mb-0">➕ Шинэ зөвлөгөө нэмэх</h4>
        </div>

        
        @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-3">
            <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <div style="background:white; border-radius:var(--radius-lg); padding:32px; box-shadow:var(--shadow-sm)">
            <form method="POST" action="{{ route('admin.tips.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-10">
                        <label class="form-label">Гарчиг *</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Дүрс тэмдэг</label>
                        <input type="text" name="icon" class="form-control" value="{{ old('icon', '💡') }}" placeholder="💡">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Агуулга *</label>
                        <textarea name="content" class="form-control" rows="6" required placeholder="Markdown дэмждэг. *тод* = тод, жагсаалтын тулд • ашигла">{{ old('content') }}</textarea>
                        <div class="text-muted mt-1" style="font-size:12px">Markdown загвар дэмждэг. Шинэ мөр = Enter</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ангилал *</label>
                        <select name="category" class="form-select" required>
                            <option value="">Сонгох</option>
                            @foreach(['morning_routine' => 'Өглөөний арчилгаа', 'evening_routine' => 'Оройн арчилгаа', 'diet' => 'Хоол тэжээл', 'lifestyle' => 'Амьдралын хэв маяг', 'acne_treatment' => 'Батга эмчлэлт'] as $val => $label)
                            <option value="{{ $val }}" {{ old('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Тохирох арьсны төрөл *</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach(['dry' => '💧 Хуурай', 'oily' => '✨ Тослог', 'combination' => '⚖️ Холимог', 'normal' => '🌸 Хэвийн', 'sensitive' => '🌿 Мэдрэмтгий'] as $val => $label)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="suitable_for[]"
                                    value="{{ $val }}" id="st_{{ $val }}"
                                    {{ in_array($val, old('suitable_for', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="st_{{ $val }}">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                            <label class="form-check-label" for="isActive">Идэвхтэй байдлаар нийтлэх</label>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary px-5 py-2">
                            <i class="fa fa-save me-2"></i>Хадгалах
                        </button>
                        <a href="{{ route('admin.tips') }}" class="btn btn-outline-secondary ms-2 px-5 py-2">Болих</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection