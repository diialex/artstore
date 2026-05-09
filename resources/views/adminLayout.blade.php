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
                    <img src="{{ asset('media/images/logo.png') }}" alt="Logo Hanger" class="cursor-pointer" style="height: 70px; width: auto; object-fit: contain;">
                </div>

                <div class="col-4 ms-auto d-flex justify-content-end gap-2 gap-md-3 align-items-center z-3">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->username }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><h6 class="dropdown-header">Opciones de cuenta</h6></li>
                            @if (auth()->user()->roles->where('name', 'admin')->first())
                                <li><a class="dropdown-item" href="{{ route('controlPanel.dashboard') }}"><i class="bi bi-person me-2"></i>Panel administrador</a></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
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
                <li class="mb-2">
                    <button class="btn w-100 d-flex justify-content-between align-items-center" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#menuUsuarios" 
                            aria-expanded="false">
                        <span><i class="bi {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'bi-people-fill' : 'bi-people' }}"></i> Usuarios</span>
                        <i class="bi bi-chevron-right small arrow-icon"></i>
                    </button>

                    <div class="collapse" id="menuUsuarios">
                        <div class="list-group list-group-flush ps-3 pt-2">
                            <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                                <i class="bi {{ request()->routeIs('users.*') ? 'bi-people-fill' : 'bi-people' }}"></i> Usuarios
                            </a>
                            <a href="{{ route('roles.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                                <i class="bi {{ request()->routeIs('roles.*') ? 'bi-people-fill' : 'bi-people' }}"></i> Roles
                            </a>
                        </div>
                    </div>
                </li>

                <li class="mb-2">
                    <button class="btn w-100 d-flex justify-content-between align-items-center" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#menuProductos" 
                            aria-expanded="false">
                        <span><i class="bi {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'bi-box2-heart-fill' : 'bi-box2-heart' }}"></i> Productos</span>
                        <i class="bi bi-chevron-right small arrow-icon"></i>
                    </button>

                    <div class="collapse" id="menuProductos">
                        <div class="list-group list-group-flush ps-3 pt-2">
                            <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                                <i class="bi {{ request()->routeIs('products.*') ? 'bi-box2-heart-fill' : 'bi-box2-heart' }}"></i> Productos
                            </a>
                            <a href="{{ route('categories.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                                <i class="bi {{ request()->routeIs('categories.*') ? 'bi-tag-fill' : 'bi-tag' }}"></i> Categorias
                            </a>
                        </div>
                    </div>
                </li>

                <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action border-0 py-3">
                    <i class="bi {{ request()->routeIs('orders.*') ? 'bi-bag-fill' : 'bi-bag' }}"></i> Pedidos
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