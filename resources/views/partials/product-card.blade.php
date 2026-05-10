<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden producto-card">
    
    <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark d-flex flex-column h-100">
        
        @if($product->image_url)
            <img src="{{ asset($product->image_url) }}" 
                         class="img-fluid w-100 object-fit-cover" 
                         alt="{{ $product->title }}" 
                         style="height: 250px;">
        @else
            <div class="card-img-top bg-light d-flex align-items-center justify-content-center text-muted border-bottom" 
                 style="height: 250px;">
                <span><i class="bi bi-camera me-2"></i>Sin imagen</span>
            </div>
        @endif

        <div class="card-body d-flex flex-column mt-2">
            <h5 class="card-title fw-bold fs-4">{{ $product->title }}</h5>
            <p class="card-text text-muted small flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
            
            <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                <span class="fs-4 fw-bold text-dark">{{ number_format($product->price, 2) }} €</span>
                <span class="badge bg-success rounded-pill px-3 py-2">Stock: {{ $product->total_stock ?? $product->stock ?? 0 }}</span>
            </div>
        </div>
    </a>
    
    <div class="card-footer bg-white border-0 pt-0 pb-4 px-3 mt-auto">
        
        @guest
            <a href="{{ route('login') }}" class="btn btn-outline-dark w-100 fw-bold rounded-pill">
                <i class="bi bi-box-arrow-in-right me-2"></i>Inicia sesión
            </a>
        @endguest

        @auth
            @if(auth()->user()->roles->contains('id', 1)) 
                <div class="d-flex gap-2 mt-2 pt-2 border-top">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning btn-sm flex-fill fw-bold rounded-pill">
                        <i class="bi bi-pencil me-1"></i> Editar
                    </a>
                    
                    <form action="{{ route('products.delete', $product) }}" method="POST" class="flex-fill" onsubmit="return confirm('¿Estás seguro de que quieres aniquilar este producto?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-bold rounded-pill">
                            <i class="bi bi-trash3 me-1"></i> Borrar
                        </button>
                    </form>
                </div>
            @endif

            @if(auth()->user()->roles->contains('id', 2))
                <div class="d-flex gap-2 align-items-center">
                    
                    {{-- Añadir a la Cesta --}}
                    <form action="{{ route('orders.addProduct', $product) }}" method="POST" class="flex-fill m-0">
                        @csrf
                        <button type="submit" class="btn btn-dark w-100 fw-bold rounded-pill py-2 text-uppercase tracking-wide">
                            <i class="bi bi-cart-plus me-2"></i>@lang('messages.add_to_cart')
                        </button>
                    </form>

                    @if($isFavoritesPage ?? false)
                        <form action="{{ route('users.favorites.remove', $product) }}" method="POST" class="m-0" onsubmit="return confirm('¿Eliminar de favoritos?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;" title="Eliminar de favoritos">
                                <i class="bi bi-trash3 fs-5"></i>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('users.favorites.add') }}" method="POST" class="m-0 add-favorite-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-outline-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;" title="Añadir a favoritos">
                                <i class="bi bi-heart fs-5"></i>
                            </button>
                        </form>
                    @endif

                </div>
            @endif
        @endauth
    </div>
</div>