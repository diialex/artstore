<div class="bg-white h-full border border-gray-100 shadow-sm rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-lg group">
    
    <a href="{{ route('products.show', $product) }}" class="flex flex-col h-full focus:outline-none">
        
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
            <h5 class="text-xl font-bold text-gray-900 mb-2 leading-tight group-hover:text-primary transition-colors">
                {{ $product->title }}
            </h5>
            <p class="text-sm text-gray-500 flex-grow mb-4">
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
        
        @guest
            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#iniciarSesion" 
               class="w-full inline-flex justify-center items-center px-4 py-2.5 border-2 border-dark text-dark font-bold rounded-full hover:bg-dark hover:text-white transition-colors">
                <i class="bi bi-box-arrow-in-right mr-2"></i>@lang('messages.login_to_buy')
            </a>
        @endguest

        @auth
            @if(auth()->user()->roles->contains('id', 1)) 
                <div class="flex gap-2 mt-2 pt-4 border-t border-gray-100">
                    <a href="{{ route('products.edit', $product) }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-sm font-bold hover:bg-amber-100 transition-colors">
                        <i class="bi bi-pencil mr-1"></i> @lang('messages.edit_product')
                    </a>
                    
                    <form action="{{ route('products.delete', $product) }}" method="POST" class="flex-1 m-0" onsubmit="return confirm('¿Estás seguro de que quieres aniquilar este producto?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center items-center px-3 py-2 bg-red-50 text-red-600 border border-red-200 rounded-full text-sm font-bold hover:bg-red-600 hover:text-white transition-colors">
                            <i class="bi bi-trash3 mr-1"></i> @lang('messages.delete_product')
                        </button>
                    </form>
                </div>
            @endif

            @if(auth()->user()->roles->contains('id', 2))
                <div class="flex gap-2 items-center">
                    
                    <form action="{{ route('orders.addProduct', $product) }}" method="POST" class="flex-1 m-0">
                        @csrf
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-dark text-white font-bold rounded-full uppercase tracking-wider text-sm hover:bg-opacity-90 hover:shadow-md transition-all">
                            <i class="bi bi-cart-plus mr-2"></i>@lang('messages.add_to_cart')
                        </button>
                    </form>

                    @php
                        $isFavorited = false;
                        if (auth()->check()) {
                            $favoriteList = auth()->user()->favoriteList;
                            $savedProducts = $favoriteList ? $favoriteList->products : [];
                            if (!empty($savedProducts)) {
                                $isFavorited = collect($savedProducts)->contains(function ($item) use ($product) {
                                    return is_array($item) ? ($item['id'] ?? null) == $product->id : $item == $product->id;
                                });
                            }
                        }
                    @endphp

                    <form action="{{ $isFavorited ? route('users.favorites.remove', $product->id) : route('users.favorites.add') }}" method="POST" class="m-0 js-favorite-form">
                        @csrf
                        @if($isFavorited) @method('DELETE') @endif
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <button type="submit" class="js-favorite-btn bg-transparent border-0 p-2 flex items-center justify-center transition-transform duration-300 hover:scale-125 focus:outline-none" title="Favoritos">
                            @if($isFavorited)
                                <i class="bi bi-heart-fill text-primary text-2xl drop-shadow-md animate-pulse icon-heart"></i>
                            @else
                                <i class="bi bi-heart text-gray-400 hover:text-primary text-2xl drop-shadow-sm transition-colors icon-heart"></i>
                            @endif
                        </button>
                    </form>

                </div>
            @endif
        @endauth
    </div>
</div>