@extends('headLayout')
@section('title', 'Control Panel')
@section('pagina')
<body class="bg-body-bg flex flex-col min-h-screen font-sans text-dark">
    
    <header class="sticky top-0 z-50 bg-primary border-b border-primary shadow-sm">
        <nav class="px-4 py-3 w-full">
            <div class="flex justify-between items-center max-w-[1400px] mx-auto">
                
                <div class="flex items-center gap-4">
                    <button type="button" class="text-white hover:text-light transition-colors" onclick="toggleAdminMenu('menuLateral')">
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
                    <div class="relative inline-block">
                        <button type="button" onclick="toggleAdminDropdown(event)" class="text-white font-medium hover:text-light transition-colors flex items-center gap-2 focus:outline-none py-1">
                            {{ auth()->user()->username }}
                            <i class="bi bi-chevron-down text-xs transition-transform duration-200" id="adminDropdownIcon"></i>
                        </button>

                        <div id="adminDropdownMenu" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible -translate-y-2 transition-all duration-200 ease-out border border-gray-100 overflow-hidden z-[100] top-full origin-top-right">
                            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                                <h6 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Opciones de cuenta</h6>
                            </div>
                            
                            <ul class="py-2 flex flex-col">
                                @if (auth()->user()->roles->contains('id', 1))
                                    <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="{{ route('controlPanel.dashboard') }}"><i class="bi bi-person-gear text-lg"></i>Panel administrador</a></li>
                                @endif
                                
                                @if(auth()->user()->roles->contains('id', 2))
                                    <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="{{ route('users.show', auth()->user()->username) }}"><i class="bi bi-person text-lg"></i>Mi Perfil</a></li>
                                    <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="{{ route('orders.index') }}"><i class="bi bi-bag text-lg"></i>Mis Pedidos</a></li>
                                    <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="/favoritos"><i class="bi bi-heart text-lg"></i>Favoritos</a></li>
                                @endif
                            </ul>
                            
                            <div class="border-t border-gray-100">
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-red-500 hover:bg-red-50 transition-colors flex items-center gap-3 text-sm font-bold">
                                        <i class="bi bi-box-arrow-right text-lg"></i>Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div id="adminOverlay" class="fixed inset-0 bg-black/50 z-[60] hidden opacity-0 transition-opacity duration-300" onclick="closeAdminMenu()"></div>

    <div id="menuLateral" class="fixed inset-y-0 left-0 w-80 bg-white text-dark z-[70] transform -translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50">
            <h5 class="text-sm font-black uppercase tracking-widest text-primary">Administración</h5>
            <button onclick="closeAdminMenu()" class="text-gray-400 hover:text-dark transition-colors"><i class="bi bi-x-lg text-xl"></i></button>
        </div>
        
        <div class="overflow-y-auto flex-grow">
            <ul class="flex flex-col">
                <li>
                    <a href="{{ route('controlPanel.dashboard') }}" class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 transition-colors {{ request()->routeIs('controlPanel.dashboard') ? 'bg-light text-primary font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i class="bi {{ request()->routeIs('controlPanel.dashboard') ? 'bi-bar-chart-line-fill' : 'bi-bar-chart-line' }} text-lg"></i> Dashboard
                    </a>
                </li>

                <li>
                    <button onclick="toggleAdminAccordion('submenuUsuarios', 'chevronUsuarios')" class="w-full flex justify-between items-center px-6 py-4 border-b border-gray-100 text-gray-700 hover:bg-gray-50 transition-colors focus:outline-none {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'bg-gray-50' : '' }}">
                        <span class="flex items-center gap-3 {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'text-primary font-bold' : '' }}">
                            <i class="bi {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'bi-people-fill' : 'bi-people' }} text-lg"></i> Usuarios
                        </span>
                        <i id="chevronUsuarios" class="bi bi-chevron-down text-xs transition-transform duration-300 {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="submenuUsuarios" class="bg-gray-50 overflow-hidden transition-all duration-300 {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'max-h-40 border-b border-gray-100' : 'max-h-0' }}">
                        <ul class="py-2 px-6 flex flex-col gap-1">
                            <li><a href="{{ route('users.index') }}" class="flex items-center gap-3 py-2 text-sm {{ request()->routeIs('users.*') ? 'text-primary font-bold' : 'text-gray-600 hover:text-dark' }}"><i class="bi {{ request()->routeIs('users.*') ? 'bi-person-fill' : 'bi-person' }}"></i> Lista de Usuarios</a></li>
                            <li><a href="{{ route('roles.index') }}" class="flex items-center gap-3 py-2 text-sm {{ request()->routeIs('roles.*') ? 'text-primary font-bold' : 'text-gray-600 hover:text-dark' }}"><i class="bi {{ request()->routeIs('roles.*') ? 'bi-shield-lock-fill' : 'bi-shield-lock' }}"></i> Roles y Permisos</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <button onclick="toggleAdminAccordion('submenuCatalogo', 'chevronCatalogo')" class="w-full flex justify-between items-center px-6 py-4 border-b border-gray-100 text-gray-700 hover:bg-gray-50 transition-colors focus:outline-none {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'bg-gray-50' : '' }}">
                        <span class="flex items-center gap-3 {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'text-primary font-bold' : '' }}">
                            <i class="bi {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'bi-box2-heart-fill' : 'bi-box2-heart' }} text-lg"></i> Catálogo
                        </span>
                        <i id="chevronCatalogo" class="bi bi-chevron-down text-xs transition-transform duration-300 {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="submenuCatalogo" class="bg-gray-50 overflow-hidden transition-all duration-300 {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'max-h-40 border-b border-gray-100' : 'max-h-0' }}">
                        <ul class="py-2 px-6 flex flex-col gap-1">
                            <li><a href="{{ route('products.index') }}" class="flex items-center gap-3 py-2 text-sm {{ request()->routeIs('products.*') ? 'text-primary font-bold' : 'text-gray-600 hover:text-dark' }}"><i class="bi {{ request()->routeIs('products.*') ? 'bi-box-fill' : 'bi-box' }}"></i> Productos</a></li>
                            <li><a href="{{ route('categories.index') }}" class="flex items-center gap-3 py-2 text-sm {{ request()->routeIs('categories.*') ? 'text-primary font-bold' : 'text-gray-600 hover:text-dark' }}"><i class="bi {{ request()->routeIs('categories.*') ? 'bi-tags-fill' : 'bi-tags' }}"></i> Categorías</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 transition-colors {{ request()->routeIs('orders.*') ? 'bg-light text-primary font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i class="bi {{ request()->routeIs('orders.*') ? 'bi-bag-fill' : 'bi-bag' }} text-lg"></i> Pedidos
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <main class="w-full flex-grow">
        @yield('content')
    </main>

    <footer class="bg-dark text-white pt-12 pb-6 mt-auto w-full shadow-[0_-10px_20px_rgba(0,0,0,0.1)]">
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
                    </div>
                    <span class="text-sm font-bold text-gray-400">&copy; 2026 HANGER</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // 1. Control del Sidebar
        function toggleAdminMenu() {
            const menu = document.getElementById('menuLateral');
            const overlay = document.getElementById('adminOverlay');
            
            menu.classList.remove('-translate-x-full');
            menu.classList.add('translate-x-0');
            
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.remove('opacity-0'), 10);
            document.body.style.overflow = 'hidden'; 
        }

        function closeAdminMenu() {
            const menu = document.getElementById('menuLateral');
            const overlay = document.getElementById('adminOverlay');
            
            menu.classList.remove('translate-x-0');
            menu.classList.add('-translate-x-full');
            
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300); 
            document.body.style.overflow = ''; 
        }

        // 2. Control de los Acordeones del Sidebar
        function toggleAdminAccordion(submenuId, chevronId) {
            const submenu = document.getElementById(submenuId);
            const chevron = document.getElementById(chevronId);
            
            if (submenu.classList.contains('max-h-0')) {
                // Abrir
                submenu.classList.remove('max-h-0');
                submenu.classList.add('max-h-40', 'border-b', 'border-gray-100'); // max-h-40 es suficiente para 2-3 enlaces
                chevron.classList.add('rotate-180');
            } else {
                // Cerrar
                submenu.classList.remove('max-h-40', 'border-b', 'border-gray-100');
                submenu.classList.add('max-h-0');
                chevron.classList.remove('rotate-180');
            }
        }

        // 3. Control del Menú Desplegable de Usuario (Idéntico al layout principal)
        function toggleAdminDropdown(event) {
            if(event) event.stopPropagation(); 
            
            const menu = document.getElementById('adminDropdownMenu');
            const icon = document.getElementById('adminDropdownIcon');
            
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

        // Cerrar dropdown si se hace clic fuera
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('adminDropdownMenu');
            if (dropdown && !dropdown.classList.contains('invisible')) {
                if (!dropdown.contains(event.target)) {
                    toggleAdminDropdown(); 
                }
            }
        });
    </script>
</body>
@endsection