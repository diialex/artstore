<div class="bg-white h-full border border-gray-100 shadow-sm rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-lg group">

    <a href="{{ route('products.show', $product) }}" class="flex flex-col h-full focus:outline-none text-decoration-none text-gray-900 hover:text-gray-900">

        <div class="relative h-[250px] w-full bg-gray-50 overflow-hidden">
            @if($product->image_url)
                <img src="{{ asset($product->image_url) }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                     alt="{{ $product->title }}">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-400 border-b border-gray-100">
                    <span class="flex items-center gap-2"><i class="bi bi-camera"></i>@lang('messages.no_image')</span>
                </div>
            @endif
        </div>

        <div class="p-5 flex flex-col flex-grow">

            <h5 class="text-xl font-bold font-sans text-gray-900 mb-2 leading-tight group-hover:text-primary transition-colors decoration-transparent no-underline">
                {{ $product->title }}
            </h5>

            <p class="text-sm font-sans text-gray-500 flex-grow mb-4 no-underline">
                {{ Str::limit($product->description, 80) }}
            </p>

            <div class="flex justify-between items-center mt-auto">
                <span class="text-xl font-black text-dark">{{ number_format($product->price, 2) }} €</span>
                <span class="bg-success bg-opacity-20 text-green-800 text-xs font-bold px-3 py-1.5 rounded-full">
                    Stock: {{ $product->total_stock ?? $product->stock ?? 0 }}
                </span>
            </div>
        </div>
    </a>

    <div class="p-5 pt-0 bg-white mt-auto">
        <div class="flex gap-2 items-end">

            @php
                $totalStock = ($product->total_stock ?? $product->stock ?? 0);
            @endphp

            @if($totalStock > 0)
                <a href="{{ route('products.show', $product) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-[#212529] text-white font-bold rounded-full uppercase tracking-wider text-xs hover:bg-opacity-90 transition-colors no-underline">
                    <i class="bi bi-cart-plus mr-2 text-sm"></i>@lang('messages.add_to_cart')
                </a>
            @else
                <button type="button" onclick="toggleMenu('iniciarSesion')" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-amber-100 text-amber-700 font-bold rounded-full uppercase tracking-wider text-xs hover:bg-amber-200 transition-colors cursor-pointer border border-amber-300">
                    <i class="bi bi-bookmark mr-2 text-sm"></i>@lang('messages.reserve')
                </button>
            @endif

            @auth
                @php
                    $isFavorited = false;
                    $favoriteList = auth()->user()->favoriteList;
                    $savedProducts = $favoriteList ? $favoriteList->products : [];
                    if (!empty($savedProducts)) {
                        $isFavorited = collect($savedProducts)->contains(function ($item) use ($product) {
                            return is_array($item) ? ($item['id'] ?? null) == $product->id : $item == $product->id;
                        });
                    }
                @endphp

                <form action="{{ $isFavorited ? route('users.favorites.remove', $product->id) : route('users.favorites.add') }}" method="POST" class="m-0 js-favorite-form shrink-0">
                    @csrf
                    @if($isFavorited) @method('DELETE') @endif
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <button type="submit"
                            class="js-favorite-btn h-[42px] w-[42px] flex items-center justify-center transition-all duration-200 focus:outline-none hover:scale-105"
                            title="{{ $isFavorited ? 'Eliminar de favoritos' : 'Añadir a favoritos' }}">
                        @if($isFavorited)
                            <i class="bi bi-heart-fill text-primary text-lg icon-heart animate-pulse"></i>
                        @else
                            <i class="bi bi-heart text-gray-400 text-lg icon-heart transition-colors"></i>
                        @endif
                    </button>
                </form>
            @else
                <button type="button" onclick="toggleMenu('iniciarSesion')"
                        class="js-favorite-btn h-[42px] w-[42px] flex items-center justify-center transition-all duration-200 focus:outline-none hover:scale-105 shrink-0"
                        title="Inicia sesión para añadir a favoritos">
                    <i class="bi bi-heart text-gray-400 text-lg transition-colors"></i>
                </button>
            @endauth

        </div>
    </div>
</div>
