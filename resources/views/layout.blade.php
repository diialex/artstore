@extends('headLayout')
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
                    @auth
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->username }}
                            </a>

                            <!-- El Menú Desplegable -->
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><h6 class="dropdown-header">Opciones de cuenta</h6></li>
                                @if (auth()->user()->roles->where('name', 'admin')->first())
                                    <li><a class="dropdown-item" href="/perfil"><i class="bi bi-person me-2"></i>Panel administrador</a></li>
                                @endif
                                @if(auth()->user()->roles->where('name', 'seller')->first())
                                    <li><a class="dropdown-item" href="/perfil"><i class="bi bi-person me-2"></i>Mi Tienda</a></li>
                                @endif
                                @if (auth()->user()->roles->where('name', 'user')->first())
                                    <li><a class="dropdown-item" href="/perfil"><i class="bi bi-person me-2"></i>Mi Perfil</a></li>
                                    <li><a class="dropdown-item" href="/pedidos"><i class="bi bi-bag me-2"></i>Mis Pedidos</a></li>
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
                    <a href="{{ route('orders.index') }}" class="text-dark text-decoration-none">
                        <i class="bi bi-bag fs-2 cursor-pointer mb-0"></i>
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <main class="container-fluid py-3 flex-fill min-vh-100">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous">
    </script>

    <div class="offcanvas offcanvas-start bg-light text-black" tabindex="-1" id="menuLateral">
        <div class="offcanvas-header">
            <i class="bi bi-x-lg fs-2 clicable" data-bs-dismiss="offcanvas"></i>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled me-4 pe-3">
                <li class="py-2 border-bottom border-secondary"><a href="{{ url('/') }}" 
                        class="text-black text-decoration-none fs-5">Inicio</a></li>
                <li class="py-2 border-bottom border-secondary"><a href="#"
                        class="text-black text-decoration-none fs-5">Descubrir - TODO</a></li>
                <li class="py-2 border-bottom border-secondary"><a href="#"
                        class="text-black text-decoration-none fs-5">Social - TODO</a></li>
                <li class="py-2"><a href="#" class="text-black text-decoration-none fs-5">Info - TODO</a></li>
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

            
            @auth
                <div class="text-center mt-4">
                    <i class="bi bi-person-circle display-1 text-primary"></i>
                    <h3 class="mt-3 fw-bold">¡Hola, {{ auth()->user()->username }}!</h3>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                    
                    <hr class="border-secondary border-2 my-4 mx-3">
                    
                    <a href="{{ route('home') }}" class="btn btn-dark w-100 mb-3 fs-5">Mi Panel</a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 fs-5">Cerrar Sesión</button>
                    </form>
                </div>
            @endauth

        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection