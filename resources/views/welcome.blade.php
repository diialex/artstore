@extends('layout')
@section('title', 'Inicio')
@section('content')
    <main class="w-full">
        @php
            $selectedCategoryIds = $selectedCategoryIds ?? [];
            $hasCategoryFilter = count($selectedCategoryIds) > 0;
            $isCatalogView = $isCatalogView ?? $hasCategoryFilter;
            $sort = $sort ?? null;
        @endphp

        @if(!$isCatalogView)
            <div class="relative w-full h-[60vh] min-h-[400px] overflow-hidden js-hero-slider bg-dark">
                <div class="absolute top-10 left-1/2 transform -translate-x-1/2 z-20 pointer-events-none">
                    <img src="{{ asset('storage/media/images/HG.png') }}" alt="Logo" class="max-h-[200px] w-auto object-contain drop-shadow-2xl filter contrast-125">
                </div>
                
                <div class="relative w-full h-full">
                    @foreach($carouselImages as $index => $image)
                        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out js-slide {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}">
                            <img src="{{ asset($image) }}" class="w-full h-full object-cover object-center" alt="Slide {{ $index + 1 }}" />
                            <div class="absolute inset-0 bg-black/20"></div> </div>
                    @endforeach
                </div>
                
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex gap-3">
                    @foreach($carouselImages as $index => $image)
                        <button type="button" class="w-12 h-1.5 rounded-full transition-all duration-300 js-slide-indicator {{ $index === 0 ? 'bg-white shadow-[0_0_10px_rgba(255,255,255,0.8)]' : 'bg-white/40 hover:bg-white/70' }}" data-slide="{{ $index }}" aria-label="Ir al slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            </div>

            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-8">
                <div class="mb-8">
                    <h2 class="text-3xl md:text-4xl font-black uppercase tracking-widest text-dark">@lang('messages.categories')</h2>
                    <div class="h-1 w-full bg-dark mt-3"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categories as $category)
                        <a href="{{ route('home', ['categories' => [$category->id]]) }}" class="block group relative aspect-square rounded-2xl overflow-hidden shadow-sm cursor-pointer">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            
                            <div class="absolute inset-0 bg-dark/50 transition-colors duration-500 group-hover:bg-dark/25"></div>
                            
                            <div class="absolute inset-0 flex items-center justify-center p-4">
                                <h3 class="text-white text-3xl md:text-4xl font-black uppercase tracking-widest text-center drop-shadow-lg">{{ $category->name }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 {{ $isCatalogView ? 'mt-8' : 'mt-16' }} mb-20">
            <div class="mb-8">
                @php
                    $selectedCategoryNames = $categories
                        ->whereIn('id', $selectedCategoryIds)
                        ->pluck('name');
                    $titulo = $selectedCategoryNames->isNotEmpty()
                        ? $selectedCategoryNames->join(' + ')
                        : trans('messages.all_products');
                @endphp

                <div class="flex flex-wrap items-center gap-2 mb-6">
                    @foreach($categories as $category)
                        @php
                            $isSelected = in_array($category->id, $selectedCategoryIds);
                            $nextCategoryIds = $isSelected
                                ? array_values(array_diff($selectedCategoryIds, [$category->id]))
                                : array_values(array_unique([...$selectedCategoryIds, $category->id]));
                            $categoryParams = empty($nextCategoryIds)
                                ? ['catalog' => 1]
                                : ['categories' => $nextCategoryIds];
                            if ($sort) {
                                $categoryParams['sort'] = $sort;
                            }
                            $categoryUrl = route('home', $categoryParams);
                        @endphp

                        <a href="{{ $categoryUrl }}"
                           class="no-decoration inline-flex items-center gap-2 px-4 py-2 rounded-full border text-sm font-black uppercase tracking-widest transition-colors {{ $isSelected ? 'bg-dark text-white border-dark' : 'bg-white text-dark border-gray-300 hover:border-dark' }}">
                            {{ $category->name }}
                            @if($isSelected)
                                <i class="bi bi-x-lg text-xs"></i>
                            @endif
                        </a>
                    @endforeach
                </div>

                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <h2 class="text-3xl md:text-4xl font-black uppercase tracking-widest text-dark">{{ $titulo }}</h2>

                    <form method="GET" action="{{ route('home') }}" class="w-full md:w-auto">
                        @foreach($selectedCategoryIds as $selectedCategoryId)
                            <input type="hidden" name="categories[]" value="{{ $selectedCategoryId }}">
                        @endforeach
                        @if(!$hasCategoryFilter)
                            <input type="hidden" name="catalog" value="1">
                        @endif

                        <div class="relative">
                            <select name="sort"
                                    onchange="this.form.submit()"
                                    class="w-full md:w-[260px] appearance-none bg-white border border-gray-300 text-dark text-sm rounded-full px-5 py-2.5 pr-10 font-black uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary cursor-pointer">
                                <option value="" {{ !$sort ? 'selected' : '' }}>Ordenar</option>
                                <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Más barato primero</option>
                                <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Más caro primero</option>
                                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Más reciente</option>
                                <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Más antiguo</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500">
                                <i class="bi bi-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="h-1 w-full bg-dark mt-3"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </main>

    <script src="lib/own/videoHover.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.js-slide');
            const indicators = document.querySelectorAll('.js-slide-indicator');
            let currentSlide = 0;
            let slideInterval;

            if (slides.length > 1) {
                function goToSlide(index) {
                    slides[currentSlide].classList.remove('opacity-100', 'z-10');
                    slides[currentSlide].classList.add('opacity-0', 'z-0');
                    indicators[currentSlide].classList.remove('bg-white', 'shadow-[0_0_10px_rgba(255,255,255,0.8)]');
                    indicators[currentSlide].classList.add('bg-white/40');

                    currentSlide = index;

                    slides[currentSlide].classList.remove('opacity-0', 'z-0');
                    slides[currentSlide].classList.add('opacity-100', 'z-10');
                    indicators[currentSlide].classList.remove('bg-white/40');
                    indicators[currentSlide].classList.add('bg-white', 'shadow-[0_0_10px_rgba(255,255,255,0.8)]');
                }

                function nextSlide() {
                    goToSlide((currentSlide + 1) % slides.length);
                }

                slideInterval = setInterval(nextSlide, 6000);

                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => {
                        clearInterval(slideInterval);
                        goToSlide(index);
                        slideInterval = setInterval(nextSlide, 6000); // Reiniciar temporizador
                    });
                });
            }
        });
    </script>
@endsection
