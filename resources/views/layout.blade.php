@extends('headLayout')
@section('pagina')
<body class="bg-light d-flex flex-column min-vh-100">
    <header>
        <nav class="bg-primary px-3 py-3 border-bottom sticky-top">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <i id="burger-menu" class="bi bi-list text-white fs-2 cursor-pointer" data-bs-toggle="offcanvas"
                        data-bs-target="#menuLateral"></i>
                    <a href="{{ route('home') }}" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="bi bi-shop fs-2"></i>
                    </a>
                </div>

                <div>
                    <img src="{{ asset('storage/media/images/logo.png') }}" alt="Logo Hanger" class="cursor-pointer" style="height: 70px; width: auto; object-fit: contain;">
                </div>

                <div class="col-4 ms-auto d-flex justify-content-end gap-2 gap-md-3 align-items-center z-3 position-relative">
                    @auth
                        <div class="dropdown" style="display: inline-block;">
                            <button class="btn btn-link text-white text-decoration-none dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; font-size: 1rem;">
                                {{ auth()->user()->username }}
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><h6 class="dropdown-header">Opciones de cuenta</h6></li>
                                
                                @if (auth()->user()->hasRol('admin'))
                                    <li><a class="dropdown-item" href="{{ route('controlPanel.dashboard') }}"><i class="bi bi-person-gear me-2"></i>@lang('messages.admin_panel')</a></li>
                                @endif
                                
                                @if(auth()->user()->hasRol('seller'))
                                    <li><a class="dropdown-item" href="/perfil"><i class="bi bi-shop-window me-2"></i>@lang('messages.profile')</a></li>
                                @endif
                                
                                @if (auth()->user()->hasRol('user'))
                                    <li><a class="dropdown-item" href="{{ route('users.show', auth()->user()->username) }}"><i class="bi bi-person me-2"></i>@lang('messages.profile')</a></li>
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-bag me-2"></i>@lang('messages.orders')</a></li>
                                    <li><a class="dropdown-item" href="/favoritos"><i class="bi bi-heart me-2"></i>@lang('messages.myfavs')</a></li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>@lang('messages.logout')
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <i id="perfil" class="bi bi-person text-white fs-2 cursor-pointer mb-0" data-bs-toggle="offcanvas"
                            data-bs-target="#iniciarSesion"></i>
                    @endauth
                    
                    <a href="{{ route('orders.carrito') }}" class="text-white text-decoration-none position-relative d-flex align-items-center">
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
                </div>
            </div>
        </nav>
    </header>
    
    <main class="container-fluid py-3 flex-fill">
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

    <div class="offcanvas offcanvas-start bg-light text-black" tabindex="-1" id="menuLateral">
        <div class="offcanvas-header border-bottom border-secondary">
            <h5 class="offcanvas-title text-uppercase fw-bold tracking-wide">@lang('messages.categories')</h5>
            <i class="bi bi-x-lg fs-2 clicable" data-bs-dismiss="offcanvas"></i>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled me-4 pe-3">
                <li class="py-2 border-bottom border-secondary">
                    <a href="{{ route('home') }}" class="text-black text-decoration-none fs-5 {{ !request('category') ? 'fw-bold' : '' }}">
                        @lang('messages.start')
                    </a>
                </li>

                <li class="mt-3">
                    <span class="text-muted small text-uppercase fw-bold tracking-widest">@lang('messages.collections')</span>
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
                <h4 class="mb-4 text-center">@lang('messages.welcome')</h4>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3 mb-0 p-2">
                        @lang('messages.wrong_credentials')
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" class="me-4 pe-3 mt-3">
                    @csrf
                    <label class="form-label" for="userCredential">@lang('messages.email_user')</label>
                    <input id="userCredential" type="text" name="userCredential" class="form-control" required autofocus />
                    
                    <label class="form-label mt-3" for="password">@lang('messages.password')</label>
                    <input id="password" type="password" name="password" class="form-control" placeholder="*****" required />
                    
                    <button type="submit" class="btn btn-primary mt-3 w-100">Login</button>
                    
                    <div class="text-center mt-2">
                        <a href="{{ route('password.request') }}" class="text-decoration-none text-secondary">@lang('messages.forgot_password')</a>
                    </div>

                    <p class="mt-4 mb-2 text-center border-top pt-3">@lang('messages.no_account')</p>
                    <a href="{{ route('register') }}" class="btn btn-secondary w-100"> @lang('messages.register')</a>
                </form>
            @endguest

            @auth
                <div class="text-center mt-4">
                    <i class="bi bi-person-circle display-1 text-primary"></i>
                    <h3 class="mt-3 fw-bold">@lang('messages.hello'), {{ auth()->user()->username }}!</h3>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                    
                    <hr class="border-secondary border-2 my-4 mx-3">
                    
                    <a href="{{ route('home') }}" class="btn btn-white w-100 mb-3 fs-5">@lang('messages.mypanel')</a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 fs-5">@lang('messages.logout')</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    <!-- SCRIPTS DENTRO DEL BODY -->
    <script>
        document.querySelectorAll('.add-favorite-form').forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData
                    });
                    if (response.ok) {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>
</body>
@endsection