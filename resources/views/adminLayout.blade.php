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

                        <div id="adminDropdownMenu" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible transition-all duration-200 border border-gray-100 overflow-hidden z-[100] top-full origin-top-right transform ">
                            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                                <h6 class="text-xs font-bold text-gray-500 uppercase tracking-widest">@lang('messages.account_options')</h6>
                            </div>
                            
                            <ul class="py-2 flex flex-col">
                                @if (auth()->user()->roles->contains('id', 1))
                                    <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="{{ route('controlPanel.dashboard') }}"><i class="bi bi-person-gear text-lg"></i>@lang('messages.admin_panel')</a></li>
                                @endif
                                
                                @if(auth()->user()->roles->contains('id', 2))
                                    <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="{{ route('users.show', auth()->user()->username) }}"><i class="bi bi-person text-lg"></i>@lang('messages.my_profile')</a></li>
                                    <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="{{ route('orders.index') }}"><i class="bi bi-bag text-lg"></i>@lang('messages.my_orders')</a></li>
                                    <li><a class="px-4 py-2 hover:bg-light hover:text-primary transition-colors flex items-center gap-3 text-sm text-gray-700 font-medium" href="/favoritos"><i class="bi bi-heart text-lg"></i>@lang('messages.favorites')</a></li>
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
                </div>
            </div>
        </nav>
    </header>

    <div id="adminOverlay" class="fixed inset-0 bg-black/50 z-[60] hidden opacity-0 transition-opacity duration-300" onclick="closeAdminMenu()"></div>

    <div id="menuLateral" class="fixed inset-y-0 left-0 w-80 bg-white text-dark z-[70] transform -translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
        
        <!-- Cabecera del panel -->
        <div class="flex justify-between items-center p-6 bg-gray-50 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <i class="bi bi-list-nested text-primary text-xl"></i>
                <h5 class="text-sm font-black uppercase tracking-widest text-primary">Menu</h5>
            </div>
            <button onclick="closeAdminMenu()" class="text-gray-400 hover:text-red-500 transition-colors bg-white rounded-full w-8 h-8 flex items-center justify-center shadow-sm border border-gray-200">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
        </div>
        
        <!-- Contenido principal con scroll -->
        <div class="p-6 overflow-y-auto flex-grow flex flex-col gap-6 hide-scrollbar">
            @php
                $selectedMenuCategoryIds = collect((array) request('categories', []))
                    ->when(request('category'), fn ($ids) => $ids->push(request('category')))
                    ->map(fn ($categoryId) => (int) $categoryId)
                    ->all();
            @endphp
            
            <!-- Enlace de Inicio destacado -->
            <div>
                <a href="{{ route('home') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl {{ empty($selectedMenuCategoryIds) ? 'bg-primary text-white shadow-md' : 'bg-gray-50 text-gray-700 hover:bg-light hover:text-primary' }} transition-all">
                    <i class="bi bi-house-door{{ empty($selectedMenuCategoryIds) ? '-fill' : '' }} text-lg"></i>
                    <span class="font-bold text-sm tracking-wide">@lang('messages.start')</span>
                </a>
            </div>

            <div class="w-full h-px bg-gray-100"></div>

            <!-- Sección de Categorías -->
            <div>
                <h6 class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-4 px-2 flex items-center gap-2">
                    <i class="bi bi-collection"></i> @lang('messages.collections')
                </h6>
                <ul class="flex flex-col gap-1">
                    @foreach(App\Models\Category::all() as $cat)
                        @php $isMenuCategorySelected = in_array($cat->id, $selectedMenuCategoryIds); @endphp
                        <li>
                            <a href="{{ route('home', ['categories' => [$cat->id]]) }}" 
                            class="flex items-center justify-between px-4 py-2.5 rounded-lg {{ $isMenuCategorySelected ? 'bg-light text-primary font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-dark font-medium' }} transition-colors text-sm group">
                                <div class="flex items-center gap-3">
                                    <!-- Indicador visual de categoría activa -->
                                    <div class="w-1.5 h-1.5 rounded-full {{ $isMenuCategorySelected ? 'bg-primary shadow-[0_0_8px_rgba(103,22,70,0.6)]' : 'bg-transparent group-hover:bg-gray-300' }} transition-all"></div>
                                    {{ $cat->name }}
                                </div>
                                @if($isMenuCategorySelected)
                                    <i class="bi bi-chevron-right text-xs"></i>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Banner de confianza (Envío gratis) -->
            <div class="mt-auto pt-6">
                <div class="bg-light rounded-xl p-5 text-center border border-primary/10 transition-colors hover:border-primary/30 cursor-default">
                    <i class="bi bi-box-seam text-primary text-2xl mb-2 block"></i>
                    <h6 class="text-sm font-bold text-dark mb-1">@lang('messages.send_free_waste')</h6>
                    <p class="text-xs text-gray-500">@lang('messages.free_giveback')</p>
                </div>
            </div>
        </div>

        <!-- Footer del panel con Redes Sociales -->
        <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-center gap-4">
            <a href="#" class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-gray-400 hover:text-primary shadow-sm transition-all"><i class="bi bi-instagram"></i></a>
            <a href="#" class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-gray-400 hover:text-primary shadow-sm transition-all"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-gray-400 hover:text-primary shadow-sm transition-all"><i class="bi bi-envelope"></i></a>
        </div>
    </div>

    <main class="w-full flex-grow">
        @yield('content')
    </main>

    <footer class="bg-[#3B2B30] text-[#fdebf1] pt-10 pb-6 mt-16 w-full shadow-[0_-10px_20px_rgba(0,0,0,0.1)]">
        <div class="max-w-[1400px] mx-auto px-6">
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
                
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <h2 class="text-2xl font-black tracking-widest text-white">HANGER</h2>
                    <div class="hidden md:block w-px h-6 bg-gray-600"></div>
                    <div class="flex gap-5">
                        <a href="#" class="text-gray-300 hover:text-white hover:scale-110 transition-transform"><i class="bi bi-instagram text-lg"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white hover:scale-110 transition-transform"><i class="bi bi-twitter-x text-lg"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white hover:scale-110 transition-transform"><i class="bi bi-envelope text-lg"></i></a>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('lang.switch', 'es') }}" class="px-3 py-1.5 rounded-md border {{ app()->getLocale() == 'es' ? 'border-light bg-light text-dark font-black shadow-sm' : 'border-gray-500 text-gray-300 hover:border-white hover:text-white font-medium' }} transition-colors text-xs tracking-widest uppercase">ES</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="px-3 py-1.5 rounded-md border {{ app()->getLocale() == 'en' ? 'border-light bg-light text-dark font-black shadow-sm' : 'border-gray-500 text-gray-300 hover:border-white hover:text-white font-medium' }} transition-colors text-xs tracking-widest uppercase">EN</a>
                    <a href="{{ route('lang.switch', 'fr') }}" class="px-3 py-1.5 rounded-md border {{ app()->getLocale() == 'fr' ? 'border-light bg-light text-dark font-black shadow-sm' : 'border-gray-500 text-gray-300 hover:border-white hover:text-white font-medium' }} transition-colors text-xs tracking-widest uppercase">FR</a>
                    <a href="{{ route('lang.switch', 'it') }}" class="px-3 py-1.5 rounded-md border {{ app()->getLocale() == 'it' ? 'border-light bg-light text-dark font-black shadow-sm' : 'border-gray-500 text-gray-300 hover:border-white hover:text-white font-medium' }} transition-colors text-xs tracking-widest uppercase">IT</a>
                </div>
                
            </div>

            <div class="w-full h-px bg-gray-600/50 mb-6"></div>

            <div class="flex flex-col lg:flex-row justify-between items-center gap-6 text-xs text-gray-300">
                
                <div class="flex flex-wrap justify-center lg:justify-start gap-x-4 gap-y-2 font-medium">
                    <a href="#" class="hover:text-white transition-colors">@lang('messages.terms_conditions_purchase')</a>
                    <span class="text-gray-500 hidden md:inline">|</span>
                    <a href="#" class="hover:text-white transition-colors">@lang('messages.terms_conditions_hanger')</a>
                    <span class="text-gray-500 hidden md:inline">|</span>
                    <a href="#" class="hover:text-white transition-colors">@lang('messages.privacy_policy')</a>
                    <span class="text-gray-500 hidden md:inline">|</span>
                    <a href="#" class="hover:text-white transition-colors">@lang('messages.cookie_policy')</a>
                    <span class="text-gray-500 hidden md:inline">|</span>
                    <a href="#" class="hover:text-white transition-colors">@lang('messages.privacy_management')</a>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                    <div class="flex items-center gap-3 text-lg text-light opacity-80">
                        <i class="bi bi-credit-card" title="Tarjeta de Crédito"></i>
                        <i class="bi bi-paypal" title="PayPal"></i>
                        <i class="bi bi-apple" title="Apple Pay"></i>
                    </div>
                    <span class="font-bold tracking-wider">&copy; {{ date('Y') }} HANGER.</span>
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
