<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GlowMN - Арьс Арчилгаа')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Mongolian&family=Outfit:wght@300;400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-main fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="brand-icon">✿</span>
            <span class="brand-text">GlowMN</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Нүүр</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('test.*') ? 'active' : '' }}" href="{{ route('test.show') }}">Арьсны тест</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('tips.*') ? 'active' : '' }}" href="{{ route('tips.index') }}">Зөвлөгөө</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Бүтээгдэхүүн</a></li>
            </ul>
            <div class="navbar-nav gap-2">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-warning">
                            <i class="fa fa-crown"></i> Админ
                        </a>
                    @endif
                    <div class="dropdown">
                        <button class="btn btn-user dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}" class="user-avatar-sm" alt="">
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fa fa-gauge me-2"></i>Хяналтын самбар</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fa fa-user me-2"></i>Профайл</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fa fa-sign-out me-2"></i>Гарах</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-nav-ghost btn-sm">Нэвтрэх</a>
                    <a href="{{ route('register') }}" class="btn btn-nav-cta btn-sm">Бүртгүүлэх</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- FLASH MESSAGES -->
@if(session('success'))
    <div class="alert-float alert alert-success alert-dismissible" role="alert">
        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert-float alert alert-danger alert-dismissible" role="alert">
        <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- MAIN CONTENT -->
<main class="main-content">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="brand-icon-lg">✿</div>
                <h5 class="fw-bold">GlowMN</h5>
                <p class="text-muted small">Монгол хэрэглэгчдэд зориулсан арьс арчилгааны мэдлэг болон зөвлөгөөний платформ.</p>
            </div>
            <div class="col-lg-2 col-6 mb-4">
                <h6 class="fw-semibold mb-3">Хуудас</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('home') }}">Нүүр</a></li>
                    <li><a href="{{ route('test.show') }}">Арьсны тест</a></li>
                    <li><a href="{{ route('tips.index') }}">Зөвлөгөө</a></li>
                    <li><a href="{{ route('products.index') }}">Бүтээгдэхүүн</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6 mb-4">
                <h6 class="fw-semibold mb-3">Арьсны төрөл</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('products.index', ['skin_type' => 'dry']) }}">Хуурай арьс</a></li>
                    <li><a href="{{ route('products.index', ['skin_type' => 'oily']) }}">Тослог арьс</a></li>
                    <li><a href="{{ route('products.index', ['skin_type' => 'combination']) }}">Холимог арьс</a></li>
                    <li><a href="{{ route('products.index', ['skin_type' => 'sensitive']) }}">Мэдрэмтгий арьс</a></li>
                </ul>
            </div>
            <div class="col-lg-4 mb-4">
                <h6 class="fw-semibold mb-3">Тест өгөх</h6>
                <p class="text-muted small">Арьсны төрлөө мэдмээр байна уу? Манай шинжлэх ухааны үндэслэлтэй тестийг аваарай!</p>
                <a href="{{ route('test.show') }}" class="btn btn-primary btn-sm">Тест өгөх →</a>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="text-center text-muted small py-2">
            © {{ date('Y') }} GlowMN. Монголд зориулсан арьс арчилгааны платформ.
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
