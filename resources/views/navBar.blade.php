<header class="sticky top-0 z-50 bg-primary border-b border-primary shadow-sm">
    <nav class="px-4 py-3 w-full">
        <div class="flex justify-between items-center max-w-[1400px] mx-auto">
            
            <!-- Menú Lateral y Home -->
            <div class="flex items-center gap-4">
                <button type="button" class="text-white hover:text-light transition-colors" onclick="toggleMenu('menuLateral')">
                    <i class="bi bi-list text-3xl"></i>
                </button>
                @can('store-access')
                <a href="{{ route('home') }}" class="text-white hover:text-light transition-colors flex items-center">
                    <i class="bi bi-house-door{{ request()->routeIs('home') ? '-fill' : '' }} text-2xl"></i>
                </a>
                @endcan
            </div>

            <!-- Logo Central -->
            <div class="absolute left-1/2 transform -translate-x-1/2">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('storage/media/images/HANGER.png') }}" alt="Logo Hanger" class="h-[60px] w-auto object-contain cursor-pointer transition-transform">
                </a>
            </div>

            <!-- Zona Derecha: Usuario y LUEGO el Carrito -->
            <div class="flex items-center justify-end gap-5">
                
                @auth
                <!-- Dropdown de Usuario -->
                <div class="relative inline-block">
                    <button type="button" onclick="toggleNavbarDropdown(event)" class="text-white font-medium hover:text-light transition-colors flex items-center gap-2 focus:outline-none py-1">
                        {{ auth()->user()->username }}
                        <i class="bi bi-chevron-down text-xs transition-transform duration-200" id="navbarDropdownIcon"></i>
                    </button>

                    <div id="navbarDropdownMenu" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible transition-all duration-200 border border-gray-100 overflow-hidden z-[100] top-full origin-top-right transform ">
                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                            <h6 class="text-xs font-bold text-gray-500 uppercase tracking-widest">@lang('messages.account_options')</h6>
                        </div>
                        
                        <ul class="py-2 flex flex-col">
                            
                            <!-- Opciones SOLO para USUARIOS NORMALES (Rol 2) -->
                            @if(auth()->user()->roles->contains('id', 2))
                                <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="{{ route('users.show', auth()->user()->username) }}"><i class="bi bi-person text-lg"></i>@lang('messages.profile')</a></li>
                                <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="{{ route('orders.index') }}"><i class="bi bi-bag text-lg"></i>@lang('messages.orders')</a></li>
                                <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="/favoritos"><i class="bi bi-heart text-lg"></i>@lang('messages.favorites')</a></li>
                            @endif
                            
                            <!-- Opciones SOLO para VENDEDORES -->
                            @if(auth()->user()->hasRol('seller'))
                                <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="/perfil"><i class="bi bi-shop-window text-lg"></i>Panel Vendedor</a></li>
                            @endif

                            <!-- Opciones SOLO para ADMINS (Rol 1) -->
                            @if (auth()->user()->roles->contains('id', 1))
                                <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-bold" href="{{ route('controlPanel.dashboard') }}"><i class="bi bi-shield-lock text-lg"></i>@lang('messages.admin_panel')</a></li>
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
                @endauth
                
                @guest
                <button type="button" onclick="toggleMenu('iniciarSesion')" aria-label="Login" class="text-white hover:text-light transition-colors flex items-center">
                    <i class="bi bi-person text-2xl"></i>
                </button>
                @endguest

                <!-- BOTÓN DEL CARRITO (A la derecha del todo) -->
                @can('store-access')
                <a href="{{ route('orders.carrito') }}" class="text-white hover:text-light transition-colors relative flex items-center mt-1">
                    <i class="bi {{ request()->routeIs('orders.carrito') ? 'bi-cart-fill' : 'bi-cart3' }} text-xl"></i>
                    @if(($cartItemCount ?? 0) > 0)
                        <span class="absolute -top-2 -right-2.5 bg-white text-primary text-[10px] font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1 shadow-md">{{ $cartItemCount > 99 ? '99+' : $cartItemCount }}</span>
                    @endif
                </a>
                @endcan
            </div>
        </div>
    </nav>
</header>

<script>
    function toggleNavbarDropdown(event) {
        if(event) event.stopPropagation(); 
        
        const menu = document.getElementById('navbarDropdownMenu');
        const icon = document.getElementById('navbarDropdownIcon');
        
        if (menu.classList.contains('invisible')) {
            menu.classList.remove('invisible', 'opacity-0', '-translate-y-2');
            menu.classList.add('visible', 'opacity-100', 'translate-y-0');
            icon.classList.add('rotate-180');
        } else {
            menu.classList.remove('visible', 'opacity-100', 'translate-y-0');
            menu.classList.add('invisible', 'opacity-0', '-translate-y-2');
            icon.classList.remove('rotate-180');
        }
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('navbarDropdownMenu');
        if (dropdown && !dropdown.classList.contains('invisible')) {
            if (!dropdown.contains(event.target)) {
                toggleNavbarDropdown(); 
            }
        }
    });
</script>