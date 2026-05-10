@extends('headLayout')
@section('title', 'Control Panel')
@section('pagina')
<body class="bg-light d-flex flex-column min-vh-100">
    <header>
        <nav class="container-fluid sticky-top bg-primary px-3 py-3 border-bottom">
            <div class="row align-items-center">
                <div class="col-4 d-flex justify-content-start gap-2 gap-md-3 align-items-center z-3">
                    <i id="burger-menu" class="bi bi-list fs-2 cursor-pointer mb-0 text-white" data-bs-toggle="offcanvas" data-bs-target="#menuLateral"></i>
                    <a href="{{ route('home') }}" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="bi bi-shop fs-2 cursor-pointer mb-0"></i>
                    </a>
                </div>

                <div class="col-4 d-flex justify-content-center z-2">
                    <img src="{{ asset('storage/media/images/logo.png') }}" alt="Logo Hanger" style="height: 70px; width: auto; object-fit: contain;">
                </div>

                <div class="col-4 ms-auto d-flex justify-content-end gap-2 gap-md-3 align-items-center z-3">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->username }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
                            <li><h6 class="dropdown-header">Opciones de cuenta</h6></li>
                            
                            @if (auth()->user()->roles->contains('id', 1))
                                <li><a class="dropdown-item py-2" href="{{ route('controlPanel.dashboard') }}"><i class="bi bi-person-gear me-2"></i>Panel administrador</a></li>
                            @endif
                            
                            @if(auth()->user()->roles->contains('id', 2))
                                <li><a class="dropdown-item py-2" href="{{ route('users.show', auth()->user()->username) }}"><i class="bi bi-person me-2"></i>Mi Perfil</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('orders.index') }}"><i class="bi bi-bag me-2"></i>Mis Pedidos</a></li>
                                <li><a class="dropdown-item py-2" href="/favoritos"><i class="bi bi-heart me-2"></i>Favoritos</a></li>
                            @endif
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="offcanvas offcanvas-start shadow" tabindex="-1" id="menuLateral" aria-labelledby="menuLateralLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold text-uppercase tracking-wide" id="menuLateralLabel">Administración</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <ul class="list-unstyled mb-0">
                <li>
                    <a href="{{ route('controlPanel.dashboard') }}" class="d-block text-dark text-decoration-none border-bottom py-3 px-4 hover-bg-light {{ request()->routeIs('controlPanel.dashboard') ? 'fw-bold bg-light' : '' }}">
                        <i class="bi {{ request()->routeIs('controlPanel.dashboard') ? 'bi-bar-chart-line-fill' : 'bi-bar-chart-line' }} me-2"></i> Dashboard
                    </a>
                </li>

                <li>
                    <button class="btn w-100 text-start border-bottom py-3 px-4 rounded-0 d-flex justify-content-between align-items-center hover-bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#menuUsuarios" aria-expanded="false">
                        <span><i class="bi {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'bi-people-fill' : 'bi-people' }} me-2"></i> Usuarios</span>
                        <i class="bi bi-chevron-down small"></i>
                    </button>
                    <div class="collapse bg-light" id="menuUsuarios">
                        <ul class="list-unstyled ps-4 py-2 border-bottom mb-0">
                            <li><a href="{{ route('users.index') }}" class="d-block text-dark text-decoration-none py-2"><i class="bi {{ request()->routeIs('users.*') ? 'bi-person-fill' : 'bi-person' }} me-2"></i> Lista de Usuarios</a></li>
                            <li><a href="{{ route('roles.index') }}" class="d-block text-dark text-decoration-none py-2"><i class="bi {{ request()->routeIs('roles.*') ? 'bi-shield-lock-fill' : 'bi-shield-lock' }} me-2"></i> Roles y Permisos</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <button class="btn w-100 text-start border-bottom py-3 px-4 rounded-0 d-flex justify-content-between align-items-center hover-bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#menuProductos" aria-expanded="false">
                        <span><i class="bi {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'bi-box2-heart-fill' : 'bi-box2-heart' }} me-2"></i> Catálogo</span>
                        <i class="bi bi-chevron-down small"></i>
                    </button>
                    <div class="collapse bg-light" id="menuProductos">
                        <ul class="list-unstyled ps-4 py-2 border-bottom mb-0">
                            <li><a href="{{ route('products.index') }}" class="d-block text-dark text-decoration-none py-2"><i class="bi {{ request()->routeIs('products.*') ? 'bi-box-fill' : 'bi-box' }} me-2"></i> Productos</a></li>
                            <li><a href="{{ route('categories.index') }}" class="d-block text-dark text-decoration-none py-2"><i class="bi {{ request()->routeIs('categories.*') ? 'bi-tags-fill' : 'bi-tags' }} me-2"></i> Categorías</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ route('orders.index') }}" class="d-block text-dark text-decoration-none border-bottom py-3 px-4 hover-bg-light {{ request()->routeIs('orders.*') ? 'fw-bold bg-light' : '' }}">
                        <i class="bi {{ request()->routeIs('orders.*') ? 'bi-bag-fill' : 'bi-bag' }} me-2"></i> Pedidos
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <main class="container-fluid py-4 flex-fill">
        @yield('content')
    </main>

    <footer class="bg-dark text-white pt-4 pb-3 mt-5 w-100 shadow-lg">
        <div class="container-fluid px-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-9 text-center text-md-start mb-3 mb-md-0">
                    <a href="#" class="text-white-50 text-decoration-none me-3 small hover-white">@lang('messages.terms_conditions_purchase')</a>
                    <a href="#" class="text-white-50 text-decoration-none me-3 small hover-white">@lang('messages.terms_conditions_hanger')</a>
                    <a href="#" class="text-white-50 text-decoration-none me-3 small hover-white">@lang('messages.privacy_policy')</a>
                    <a href="#" class="text-white-50 text-decoration-none me-3 small hover-white">@lang('messages.cookie_policy')</a>
                    <a href="#" class="text-white-50 text-decoration-none small hover-white">@lang('messages.privacy_management')</a>
                </div>
                <div class="col-12 col-md-3 text-center text-md-end d-flex justify-content-center justify-content-md-end align-items-center gap-3">
                    <div class="small tracking-widest">
                        <a href="{{ route('lang.switch', 'es') }}" class="text-decoration-none {{ app()->getLocale() == 'es' ? 'text-white fw-bold' : 'text-white-50' }}">ES</a>
                        <span class="text-white-50 mx-1">|</span>
                        <a href="{{ route('lang.switch', 'en') }}" class="text-decoration-none {{ app()->getLocale() == 'en' ? 'text-white fw-bold' : 'text-white-50' }}">EN</a>
                    </div>
                    <span class="small fw-bold">&copy; 2026 HANGER</span>
                </div>
            </div>
        </div>
    </footer>
</body>
@endsection