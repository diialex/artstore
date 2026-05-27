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
        
        @guest
            <button type="button" onclick="toggleMenu('iniciarSesion')" 
                    class="w-full inline-flex justify-center items-center px-4 py-2.5 border-2 border-[#212529] text-[#212529] font-bold rounded-full hover:bg-[#212529] hover:text-white transition-colors cursor-pointer">
                <i class="bi bi-box-arrow-in-right mr-2"></i>@lang('messages.login_to_buy')
            </button>
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
                <div class="flex flex-col gap-2 w-full">
                    
                    <div class="flex gap-2 items-end">
                        <form action="{{ route('orders.addProduct', $product) }}" method="POST" class="flex-1 m-0 flex flex-col gap-3 js-add-cart-form">
                            @csrf
                            
                            @if($product->sizes && $product->sizes->count() > 0)
                                <div class="flex flex-wrap gap-1.5 mb-2 border-t border-gray-100 pt-3">
                                    @foreach($product->sizes as $size)
                                        @if($size->stock > 0)
                                            <div class="flex-1 min-w-[3rem]">
                                                <input type="radio" name="size_id" id="card_size_{{ $product->id }}_{{ $size->id }}" value="{{ $size->id }}" class="peer sr-only js-size-radio">
                                                
                                                <label for="card_size_{{ $product->id }}_{{ $size->id }}" 
                                                    class="flex flex-col items-center justify-center w-full py-1.5 bg-gray-100 border border-transparent text-gray-600 rounded-md cursor-pointer hover:bg-gray-200 transition-colors peer-checked:bg-[#212529] peer-checked:border-[#212529] peer-checked:text-white text-center">
                                                    
                                                    <span class="text-sm font-bold uppercase tracking-tight">{{ $size->size }}</span>
                                                    <span class="text-[0.60rem] font-medium opacity-80">{{ $size->stock }} ud</span>
                                                </label>
                                            </div>
                                        @else
                                            <div class="flex-1 min-w-[3rem]">
                                                <div class="flex flex-col items-center justify-center w-full py-1.5 bg-gray-50 border border-transparent rounded-md opacity-50 cursor-not-allowed text-gray-400 text-center">
                                                    <span class="text-sm font-bold line-through">{{ $size->size }}</span>
                                                    <span class="text-[0.60rem] font-medium">0 ud</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <div class="js-size-warning hidden text-red-500 text-xs font-bold uppercase tracking-wider text-center mt-[-4px]">
                                <i class="bi bi-exclamation-triangle mr-1"></i> Selecciona talla
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-[#212529] text-white font-bold rounded-full uppercase tracking-wider text-xs hover:bg-opacity-90 transition-colors">
                                <i class="bi bi-cart-plus mr-2 text-sm"></i>@lang('messages.add_to_cart')
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

                        <form action="{{ $isFavorited ? route('users.favorites.remove', $product->id) : route('users.favorites.add') }}" method="POST" class="m-0 js-favorite-form shrink-0">
                            @csrf
                            @if($isFavorited) @method('DELETE') @endif
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <button type="submit" 
                                    class="js-favorite-btn h-[42px] w-[42px] rounded-full border-2 flex items-center justify-center transition-all duration-200 focus:outline-none hover:scale-105
                                        {{ $isFavorited ? 'border-primary bg-primary bg-opacity-10' : 'border-gray-200 bg-white hover:border-primary' }}" 
                                    title="{{ $isFavorited ? 'Eliminar de favoritos' : 'Añadir a favoritos' }}">
                                @if($isFavorited)
                                    <i class="bi bi-heart-fill text-primary text-lg icon-heart animate-pulse"></i>
                                @else
                                    <i class="bi bi-heart text-gray-400 text-lg icon-heart transition-colors"></i>
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</div>