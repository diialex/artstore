@extends('headLayout')
@section('title', 'Control Panel')
@section('pagina')
<body class="bg-body-bg flex flex-col min-h-screen font-sans text-dark">
    
    @include('navBar')

    <div id="overlay" class="fixed inset-0 bg-black/50 z-[60] hidden opacity-0 transition-opacity duration-300" onclick="toggleMenu('menuLateral')"></div>

    <div id="menuLateral" class="fixed inset-y-0 left-0 w-80 bg-white text-dark z-[70] transform -translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
        
        <div class="flex justify-between items-center p-6 bg-gray-50 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <i class="bi bi-shield-lock-fill text-primary text-xl"></i>
                <h5 class="text-sm font-black uppercase tracking-widest text-primary">@lang('messages.administration')</h5>
            </div>
            <button onclick="toggleMenu('menuLateral')" class="text-gray-400 hover:text-red-500 transition-colors bg-white rounded-full w-8 h-8 flex items-center justify-center shadow-sm border border-gray-200">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-grow flex flex-col gap-6 hide-scrollbar">
            @php
                $selectedMenuCategoryIds = collect((array) request('categories', []))
                    ->when(request('category'), fn ($ids) => $ids->push(request('category')))
                    ->map(fn ($categoryId) => (int) $categoryId)
                    ->all();
            @endphp
            
            <div>
                <a href="{{ route('home') }}" class="group flex items-center gap-4 px-4 py-3 rounded-xl {{ !request('category') ? 'bg-primary text-white shadow-md' : 'bg-gray-50 text-gray-700 hover:bg-light hover:text-primary' }} transition-all">
                    <i class="bi bi-house-door{{ !request('category') ? '-fill' : '' }} text-lg"></i>
                    <span class="font-bold text-sm tracking-wide">@lang('messages.start')</span>
                </a>
            </div>

            <div class="w-full h-px bg-gray-100"></div>

            <div>
                <h6 class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-4 px-2 flex items-center gap-2">
                    <i class="bi bi-database"></i> Gestión de Tienda
                </h6>
                <ul class="flex flex-col gap-1">
                    @foreach(App\Models\Category::all() as $cat)
                        <li>
                            <a href="{{ route('home', ['category' => $cat->id]) }}" 
                            class="flex items-center justify-between px-4 py-2.5 rounded-lg {{ request('category') == $cat->id ? 'bg-light text-primary font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-dark font-medium' }} transition-colors text-sm group">
                                <div class="flex items-center gap-3">
                                    <!-- Indicador visual de categoría activa -->
                                    <div class="w-1.5 h-1.5 rounded-full {{ request('category') == $cat->id ? 'bg-primary shadow-[0_0_8px_rgba(103,22,70,0.6)]' : 'bg-transparent group-hover:bg-gray-300' }} transition-all"></div>
                                    {{ $cat->name }}
                                </div>
                                @if(request('category') == $cat->id)
                                    <i class="bi bi-chevron-right text-xs"></i>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="w-full h-px bg-gray-100"></div>

            <div>
                <h6 class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-4 px-2 flex items-center gap-2">
                    <i class="bi bi-shield-check"></i> Seguridad
                </h6>
                <ul class="flex flex-col gap-1">
                    <li>
                        <a href="{{ route('users.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-600 hover:bg-light hover:text-primary font-medium transition-colors text-sm group">
                            <div class="flex items-center gap-3"><i class="bi bi-people"></i> Usuarios</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('roles.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-600 hover:bg-light hover:text-primary font-medium transition-colors text-sm group">
                            <div class="flex items-center gap-3"><i class="bi bi-person-badge"></i> Roles y Permisos</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <main class="w-full flex-grow">
        @yield('content')
    </main>

    @include('footer')
    <script>
        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId);
            const overlay = document.getElementById('overlay');
            if(!menu) return;
            
            const isLeft = menuId === 'menuLateral';
            const hideClass = isLeft ? '-translate-x-full' : 'translate-x-full';
            
            if (menu.classList.contains(hideClass)) {
                menu.classList.remove(hideClass);
                menu.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                document.body.style.overflow = 'hidden'; 
            } else {
                menu.classList.remove('translate-x-0');
                menu.classList.add(hideClass);
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300); 
                document.body.style.overflow = ''; 
            }
        }
    </script>

</body>
@endsection
