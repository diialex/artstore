@extends('headLayout')
@section('pagina')
<body class="bg-light d-flex flex-column min-vh-100">
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

                <div class="col-4 d-flex justify-content-center">
                    <img src="{{ asset('storage/media/images/logo.png') }}" alt="Logo Hanger" style="height: 70px; width: auto; object-fit: contain;">
                </div>

                <div class="col-4 ms-auto d-flex justify-content-end gap-2 gap-md-3 align-items-center z-3">
                    @auth
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->username }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><h6 class="dropdown-header">Opciones de cuenta</h6></li>
                                
                                @if (auth()->user()->roles->where('name', 'admin')->first())
                                    <li><a class="dropdown-item" href="{{ route('controlPanel.dashboard') }}"><i class="bi bi-person-gear me-2"></i>Panel administrador</a></li>
                                @endif
                                
                                @if(auth()->user()->roles->where('name', 'seller')->first())
                                    <li><a class="dropdown-item" href="/perfil"><i class="bi bi-shop-window me-2"></i>Mi Tienda</a></li>
                                @endif
                                
                                @if (auth()->user()->roles->where('name', 'user')->first())
                                    <li><a class="dropdown-item" href="{{ route('users.show', auth()->user()->username) }}"><i class="bi bi-person me-2"></i>Mi Perfil</a></li>
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-bag me-2"></i>Mis Pedidos</a></li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
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
                    @else
                        <i id="perfil" class="bi bi-person fs-2 cursor-pointer mb-0" data-bs-toggle="offcanvas"
                            data-bs-target="#iniciarSesion"></i>
                    @endauth
                    
                    <a href="{{ route('orders.carrito') }}" class="text-dark text-decoration-none position-relative d-flex align-items-center">
                        <i class="bi bi-bag fs-2 cursor-pointer mb-0"></i>
                        @php
                            $cartCount = 0;
                            if(auth()->check()) {
                                $activeOrder = \App\Models\Order::where('user_id', auth()->id())
                                                    ->whereIn('status', ['pending', 'failed'])
                                                    ->first();
                                $cartCount = $activeOrder ? $activeOrder->items->sum('quantity') : 0;
                            }
                        @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; margin-top: 5px; margin-left: -5px;">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    {{-- FIN DE LA MAGIA --}}

                </div>
            </div>
        </nav>
    </header>
    
    <main class="container-fluid py-3 flex-fill">
        @yield('content')
    </main>

    <footer class="bg-dark text-white pt-4 pb-3 mt-5 w-100 shadow-lg ">
        <div class="container-fluid px-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-9 text-center text-md-start mb-3 mb-md-0">
                    <a href="#" class="text-white-50 text-decoration-none me-3 small hover-white">Términos y condiciones de compra</a>
                    <a href="#" class="text-white-50 text-decoration-none me-3 small hover-white">Términos y condiciones de hanger</a>
                    <a href="#" class="text-white-50 text-decoration-none me-3 small hover-white">Política de privacidad</a>
                    <a href="#" class="text-white-50 text-decoration-none me-3 small hover-white">Política de cookies</a>
                    <a href="#" class="text-white-50 text-decoration-none small hover-white">Gestión de privacidad</a>
                </div>
                <div class="col-12 col-md-3 text-center text-md-end">
                    <span class="small fw-bold">&copy; 2026 HANGER</span>
                </div>
            </div>
        </div>
    </footer>

    <div class="offcanvas offcanvas-start bg-light text-black" tabindex="-1" id="menuLateral">
        <div class="offcanvas-header border-bottom border-secondary">
            <h5 class="offcanvas-title text-uppercase fw-bold tracking-wide">Categorías</h5>
            <i class="bi bi-x-lg fs-2 clicable" data-bs-dismiss="offcanvas"></i>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled me-4 pe-3">
                <li class="py-2 border-bottom border-secondary">
                    <a href="{{ route('home') }}" class="text-black text-decoration-none fs-5 {{ !request('category') ? 'fw-bold' : '' }}">
                        Inicio / Ver Todo
                    </a>
                </li>

                <li class="mt-3">
                    <span class="text-muted small text-uppercase fw-bold tracking-widest">Colecciones</span>
                </li>
                @foreach(App\Models\Category::all() as $cat)
                    <li class="py-2 border-bottom border-secondary ps-2">
                        <a href="{{ route('home', ['category' => $cat->id]) }}" 
                        class="text-black text-decoration-none fs-6 {{ request('category') == $cat->id ? 'fw-bold text-primary' : '' }}">
                        {{ $cat->name }}
                        </a>
                    </li>
                @endforeach

                <li class="mt-4">
                    <span class="text-muted small text-uppercase fw-bold tracking-widest">Explorar</span>
                </li>
                <li class="py-2 border-bottom border-secondary">
                    <a href="#" class="text-black text-decoration-none fs-5">Descubrir - TODO</a>
                </li>
                <li class="py-2 border-bottom border-secondary">
                    <a href="#" class="text-black text-decoration-none fs-5">Social - TODO</a>
                </li>
                <li class="py-2">
                    <a href="#" class="text-black text-decoration-none fs-5">Info - TODO</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="offcanvas offcanvas-end bg-light text-black" tabindex="-1" id="iniciarSesion">
        <div class="offcanvas-header justify-content-end">
            <i class="bi bi-x-lg fs-2 clicable" data-bs-dismiss="offcanvas"></i>
        </div>
        <div class="offcanvas-body">
            @guest
                <h4 class="mb-4 text-center">Bienvenido</h4>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3 mb-0 p-2">
                        Credenciales incorrectas.
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" class="me-4 pe-3 mt-3">
                    @csrf
                    <label class="form-label" for="userCredential">Email or username:</label>
                    <input id="userCredential" type="text" name="userCredential" class="form-control" required autofocus />
                    
                    <label class="form-label mt-3" for="password">Password:</label>
                    <input id="password" type="password" name="password" class="form-control" placeholder="*****" required />
                    
                    <button type="submit" class="btn btn-primary mt-3 w-100">Login</button>
                    
                    <div class="text-center mt-2">
                        <a href="{{ route('password.request') }}" class="text-decoration-none text-secondary">¿Olvidaste tu contraseña?</a>
                    </div>

                    <p class="mt-4 mb-2 text-center border-top pt-3">¿No tienes una cuenta?</p>
                    <a href="{{ route('register') }}" class="btn btn-secondary w-100">Register</a>
                </form>
            @endguest
        </div>
    </div>
</body>
@endsection