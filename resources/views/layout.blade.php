@extends('headLayout')
@section('pagina')
<body class="bg-body-bg flex flex-col min-h-screen font-sans text-dark">
    
    <header class="sticky top-0 z-50 bg-primary border-b border-primary shadow-sm">
        <nav class="px-4 py-3 w-full">
            <div class="flex justify-between items-center max-w-[1400px] mx-auto">
                
                <div class="flex items-center gap-4">
                    <button type="button" class="text-white hover:text-light transition-colors" onclick="toggleMenu('menuLateral')">
                        <i class="bi bi-list text-3xl"></i>
                    </button>
                    <a href="{{ route('home') }}" class="text-white hover:text-light transition-colors flex items-center">
                        <i class="bi bi-shop text-2xl"></i>
                    </a>
                </div>

                <div class="absolute left-1/2 transform -translate-x-1/2">
                    <img src="{{ asset('storage/media/images/HANGER.png') }}" alt="Logo Hanger" class="h-[70px] w-auto object-contain cursor-pointer transition-transform hover:scale-105">
                </div>

                <div class="flex items-center justify-end gap-5">
                    @auth
                        <div class="relative inline-block">
                            <button type="button" onclick="toggleDropdown(event)" class="text-white font-medium hover:text-light transition-colors flex items-center gap-2 focus:outline-none py-1">
                                {{ auth()->user()->username }}
                                <i class="bi bi-chevron-down text-xs transition-transform duration-200" id="dropdownIcon"></i>
                            </button>

                            <div id="userDropdownMenu" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible transition-all duration-200 border border-gray-100 overflow-hidden z-[100] top-full origin-top-right transform scale-95">
                                <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                                    <h6 class="text-xs font-bold text-gray-500 uppercase tracking-widest">@lang('messages.account_options')</h6>
                                </div>
                                
                                <ul class="py-2 flex flex-col">
                                    @if (auth()->user()->hasRol('admin'))
                                        <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="{{ route('controlPanel.dashboard') }}"><i class="bi bi-person-gear text-lg"></i>@lang('messages.admin_panel')</a></li>
                                    @endif
                                    
                                    @if(auth()->user()->hasRol('seller'))
                                        <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="/perfil"><i class="bi bi-shop-window text-lg"></i>@lang('messages.profile')</a></li>
                                    @endif
                                    
                                    @if (auth()->user()->hasRol('user'))
                                        <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="{{ route('users.show', auth()->user()->username) }}"><i class="bi bi-person text-lg"></i>@lang('messages.profile')</a></li>
                                        <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="{{ route('orders.index') }}"><i class="bi bi-bag text-lg"></i>@lang('messages.orders')</a></li>
                                        <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="/favoritos"><i class="bi bi-heart text-lg"></i>@lang('messages.myfavs')</a></li>
                                    @endif
                                </ul>
                                
                                <div class="border-t border-gray-100">
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 text-red-500 hover:bg-red-50 transition-colors flex items-center gap-3 text-sm font-bold">
                                            <i class="bi bi-box-arrow-right text-lg"></i>@lang('messages.logout')
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <button type="button" class="text-white hover:text-light transition-colors" onclick="toggleMenu('iniciarSesion')">
                            <i class="bi bi-person text-3xl"></i>
                        </button>
                    @endauth
                    
                    <a href="{{ route('orders.carrito') }}" class="text-white hover:text-light transition-colors relative flex items-center group">
                        <i class="bi bi-bag text-2xl group-hover:scale-110 transition-transform"></i>
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
                            <span class="absolute -top-1 -right-2 bg-success text-dark text-[0.65rem] font-bold rounded-full h-5 w-5 flex items-center justify-center border-2 border-primary shadow-sm">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </nav>
    </header>
    
    <main class="w-full flex-grow">
        @yield('content')
    </main>

    <footer class="bg-dark text-white pt-12 pb-6 mt-16 w-full shadow-[0_-10px_20px_rgba(0,0,0,0.1)]">
        <div class="max-w-[1400px] mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">@lang('messages.terms_conditions_purchase')</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">@lang('messages.terms_conditions_hanger')</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">@lang('messages.privacy_policy')</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">@lang('messages.cookie_policy')</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">@lang('messages.privacy_management')</a>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-xs font-bold tracking-widest flex items-center gap-2">
                        <a href="{{ route('lang.switch', 'es') }}" class="{{ app()->getLocale() == 'es' ? 'text-white' : 'text-gray-500 hover:text-white' }} transition-colors">ES</a>
                        <span class="text-gray-600">|</span>
                        <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'text-white' : 'text-gray-500 hover:text-white' }} transition-colors">EN</a>
                                               <span class="text-gray-600">|</span>
                        <a href="{{ route('lang.switch', 'fr') }}" class="{{ app()->getLocale() == 'fr' ? 'text-white' : 'text-gray-500 hover:text-white' }} transition-colors">FR</a>
                        <span class="text-gray-600">|</span>
                        <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'text-white' : 'text-gray-500 hover:text-white' }} transition-colors">IT</a>
                    </div>
                    <span class="text-sm font-bold text-gray-400">&copy; 2026 HANGER</span>
                </div>
            </div>
        </div>
    </footer>

    <div id="overlay" class="fixed inset-0 bg-black/50 z-[60] hidden opacity-0 transition-opacity duration-300" onclick="closeAllMenus()"></div>

    <div id="menuLateral" class="fixed inset-y-0 left-0 w-80 bg-light text-dark z-[70] transform -translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h5 class="text-sm font-black uppercase tracking-widest text-primary">@lang('messages.categories')</h5>
            <button onclick="toggleMenu('menuLateral')" class="text-gray-400 hover:text-dark transition-colors"><i class="bi bi-x-lg text-xl"></i></button>
        </div>
        <div class="p-6 overflow-y-auto flex-grow">
            <ul class="flex flex-col gap-2">
                <li class="pb-4 mb-4 border-b border-gray-200">
                    <a href="{{ route('home') }}" class="text-lg {{ !request('category') ? 'font-black text-primary' : 'font-medium text-dark hover:text-primary' }} transition-colors">
                        @lang('messages.start')
                    </a>
                </li>
                
                <li class="mt-2 mb-2">
                    <span class="text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest">@lang('messages.collections')</span>
                </li>
                
                @foreach(App\Models\Category::all() as $cat)
                    <li>
                        <a href="{{ route('home', ['category' => $cat->id]) }}" 
                           class="block py-2 pl-3 border-l-2 {{ request('category') == $cat->id ? 'border-primary text-primary font-bold' : 'border-transparent text-gray-600 hover:border-gray-300 hover:text-dark' }} transition-all text-sm">
                            {{ $cat->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div id="iniciarSesion" class="fixed inset-y-0 right-0 w-96 bg-white text-dark z-[70] transform translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
        <div class="flex justify-start p-6">
            <button onclick="toggleMenu('iniciarSesion')" class="text-gray-400 hover:text-dark transition-colors"><i class="bi bi-x-lg text-xl"></i></button>
        </div>
        
        <div class="px-8 pb-8 overflow-y-auto">
            @guest
                <h4 class="text-2xl font-black text-center mb-6 text-primary">@lang('messages.welcome')</h4>
                
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 text-sm font-bold p-3 rounded-lg border border-red-200 mb-6 text-center">
                        @lang('messages.wrong_credentials')
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2" for="userCredential">@lang('messages.email_user')</label>
                        <input id="userCredential" type="text" name="userCredential" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" required autofocus />
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 mt-2" for="password">@lang('messages.password')</label>
                        <input id="password" type="password" name="password" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" placeholder="••••••••" required />
                    </div>
                    
                    <button type="submit" class="w-full bg-primary text-white font-bold uppercase tracking-widest py-4 rounded-lg hover:bg-opacity-90 transition-all mt-4 shadow-md active:scale-95">
                        Login
                    </button>
                    
                    <div class="text-center mt-2">
                        <a href="{{ route('password.request') }}" class="text-xs text-gray-500 hover:text-primary transition-colors">@lang('messages.forgot_password')</a>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                        <p class="text-sm text-gray-500 mb-4">@lang('messages.no_account')</p>
                        <a href="{{ route('register') }}" class="block w-full bg-white text-primary border-2 border-primary font-bold uppercase tracking-widest py-3 rounded-lg hover:bg-light transition-all">
                            @lang('messages.register')
                        </a>
                    </div>
                </form>
            @endguest

            @auth
                <div class="flex flex-col items-center justify-center h-full pt-10">
                    <div class="w-24 h-24 bg-light rounded-full flex items-center justify-center mb-6 text-primary border-4 border-white shadow-lg">
                        <i class="bi bi-person-fill text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-dark mb-1">@lang('messages.hello'), {{ auth()->user()->username }}!</h3>
                    <p class="text-sm text-gray-500 mb-8">{{ auth()->user()->email }}</p>
                    
                    <div class="w-full h-px bg-gray-100 mb-8"></div>
                    
                    <a href="{{ route('home') }}" class="w-full bg-dark text-white font-bold text-center py-4 rounded-xl hover:bg-opacity-90 transition-all mb-4">
                        @lang('messages.mypanel')
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full bg-red-50 text-red-600 font-bold py-4 rounded-xl hover:bg-red-600 hover:text-white border border-red-100 transition-all">
                            @lang('messages.logout')
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    <script>
       // --- 1. SCRIPT GESTOR DE MENÚS LATERALES (OFFCANVAS) ---
        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId);
            const overlay = document.getElementById('overlay');
            if(!menu) return;
            
            const isLeft = menuId === 'menuLateral';
            const hideClass = isLeft ? '-translate-x-full' : 'translate-x-full';
            
            if (menu.classList.contains(hideClass)) {
                // ABRIR
                menu.classList.remove(hideClass);
                menu.classList.add('translate-x-0'); // <- Esto soluciona que se quede pillado fuera
                
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                document.body.style.overflow = 'hidden'; 
            } else {
                // CERRAR
                menu.classList.remove('translate-x-0');
                menu.classList.add(hideClass);
                
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300); 
                document.body.style.overflow = ''; 
            }
        }

        // --- 2. SCRIPT DEL MENÚ DESPLEGABLE DEL USUARIO ---
        function toggleDropdown(event) {
            if(event) event.stopPropagation(); // Evita que el clic cierre el menú inmediatamente
            
            const menu = document.getElementById('userDropdownMenu');
            const icon = document.getElementById('dropdownIcon');
            
            if (menu.classList.contains('invisible')) {
                // Abrir
                menu.classList.remove('invisible', 'opacity-0', 'scale-95');
                menu.classList.add('visible', 'opacity-100', 'scale-100');
                icon.classList.add('rotate-180'); // Giramos la flechita
            } else {
                // Cerrar
                menu.classList.remove('visible', 'opacity-100', 'scale-100');
                menu.classList.add('invisible', 'opacity-0', 'scale-95');
                icon.classList.remove('rotate-180');
            }
        }

        // --- 3. CERRAR TODO HACIENDO CLIC FUERA ---
        function closeAllMenus() {
            // Cerrar Offcanvas si están abiertos
            ['menuLateral', 'iniciarSesion'].forEach(id => {
                const menu = document.getElementById(id);
                if (menu) {
                    const isLeft = id === 'menuLateral';
                    const hideClass = isLeft ? '-translate-x-full' : 'translate-x-full';
                    if (menu.classList.contains('translate-x-0')) {
                        toggleMenu(id);
                    }
                }
            });
        }

        // Escuchador global para cerrar el dropdown si haces clic en cualquier otro sitio de la pantalla
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdownMenu');
            if (dropdown && !dropdown.classList.contains('invisible')) {
                if (!dropdown.contains(event.target)) {
                    toggleDropdown(); // Cerramos si el clic no ha sido dentro del menú
                }
            }
        });

        // SCRIPTS QUE SÍ NECESITAN ESPERAR AL DOM (Favoritos, Tallas y Carrito)
        document.addEventListener('DOMContentLoaded', function() {
            // Favoritos
            const favoriteForms = document.querySelectorAll('.js-favorite-form');
            favoriteForms.forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault(); 
                    const url = this.action;
                    const formData = new FormData(this);
                    const icon = this.querySelector('.icon-heart');
                    const methodInput = this.querySelector('input[name="_method"]');

                    try {
                        const response = await fetch(url, {
                            method: 'POST', 
                            body: formData,
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });

                        if (response.ok) {
                            const isNowFavorited = icon.classList.contains('bi-heart'); 
                            if (isNowFavorited) {
                                icon.classList.remove('bi-heart', 'text-gray-400');
                                icon.classList.add('bi-heart-fill', 'text-primary', 'animate-pulse');
                                this.action = this.action.replace('add', 'remove/' + formData.get('product_id'));
                                if (!methodInput) {
                                    this.insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="DELETE">');
                                }
                            } else {
                                icon.classList.remove('bi-heart-fill', 'text-primary', 'animate-pulse');
                                icon.classList.add('bi-heart', 'text-gray-400');
                                this.action = this.action.replace(/remove\/\d+/, 'add');
                                if (methodInput) methodInput.remove();
                            }
                        }
                    } catch (error) {
                        console.error('Error de red al procesar el favorito', error);
                    }
                });
            });

            // Tallas (Deseleccionar)
            const sizeRadios = document.querySelectorAll('.js-size-radio');
            let lastChecked = null;
            sizeRadios.forEach(radio => {
                radio.addEventListener('click', function(e) {
                    if (lastChecked === this) {
                        this.checked = false;
                        lastChecked = null;
                    } else {
                        lastChecked = this;
                    }
                    const form = this.closest('form');
                    const warning = form.querySelector('.js-size-warning');
                    if (warning && this.checked) {
                        warning.classList.add('hidden');
                    }
                });
            });

            // Carrito (Validación de talla)
            const cartForms = document.querySelectorAll('.js-add-cart-form');
            cartForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const radios = this.querySelectorAll('input[name="size_id"]');
                    if (radios.length > 0) {
                        let isChecked = false;
                        for (let i = 0; i < radios.length; i++) {
                            if (radios[i].checked) {
                                isChecked = true;
                                break;
                            }
                        }
                        if (!isChecked) {
                            e.preventDefault(); 
                            const warning = this.querySelector('.js-size-warning');
                            if (warning) {
                                warning.classList.remove('hidden'); 
                                warning.style.transform = 'scale(1.05)';
                                setTimeout(() => warning.style.transform = 'scale(1)', 200);
                            }
                        }
                    }
                });
            });
        });
    </script>
    
</body>
@endsection