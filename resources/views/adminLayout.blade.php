@extends('headLayout')
@section('title', 'Control Panel')
@section('pagina')
<body class="bg-light">
    <header>
        <nav class="container-fluid sticky-top bg-primary px-3 py-3 border-bottom">
            <div class="row">
                <div class="col-4 d-flex justify-content-start gap-2 gap-md-3 align-items-center cursor-pointer z-3">
                    <i id="burger-menu" class="bi bi-list fs-2 cursor-pointer mb-0" data-bs-toggle="offcanvas"
                        data-bs-target="#menuLateral"></i>
                    <a href="{{ route('home') }}" class="text-dark text-decoration-none d-flex align-items-center">
                        <i class="bi bi-shop fs-2 cursor-pointer mb-0"></i>
                    </a>
                </div>

                <div class="position-absolute start-50 top-50 translate-middle w-auto d-flex justify-content-center z-2">
                    <img src="{{ asset('/storage/media/images/logo.png') }}" alt="Logo Hanger" class="cursor-pointer" style="height: 70px; width: auto; object-fit: contain;">
                </div>

                <div class="col-4 ms-auto d-flex justify-content-end gap-2 gap-md-3 align-items-center z-3">
                </div>
            </div>
        </nav>
    </header>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="menuLateral" aria-labelledby="menuLateralLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="menuLateralLabel">Menú Administrativo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="list-group list-group-flush">
                <a href="{{ route('controlPanel.dashboard') }}" class="list-group-item list-group-item-action border-0 py-3">
                    <i class="bi {{ request()->routeIs('controlPanel.dashboard') ? 'bi-bar-chart-line-fill' : 'bi-bar-chart-line' }}"></i> Dashboard
                </a>
                <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                    <i class="bi {{ request()->routeIs('users.*') ? 'bi-people-fill' : 'bi-people' }}"></i> Usuarios
                </a>
                <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                    <i class="bi {{ request()->routeIs('products.*') ? 'bi-box2-heart-fill' : 'bi-box2-heart' }}"></i> Productos
                </a>
                <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                    <i class="bi {{ request()->routeIs('products.*') ? 'bi-box2-heart-fill' : 'bi-box2-heart' }}"></i> Productos
                </a>
                <a href="#" class="list-group-item list-group-item-action border-0 py-3 text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                </a>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <main class="container-fluid py-4">
        @yield('content')
    </main>
</body>
@endsection