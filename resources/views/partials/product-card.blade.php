{{-- resources/views/partials/product-card.blade.php --}}
<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden producto-card">
    
    @if($product->image_url)
        <img src="{{ asset('storage/' . $product->image_url) }}" 
             class="card-img-top border-bottom" 
             alt="{{ $product->title }}" 
             style="height: 220px; object-fit: cover;">
    @else
        <div class="card-img-top bg-light d-flex align-items-center justify-content-center text-muted border-bottom" 
             style="height: 220px;">
            <span>📸 Sin imagen</span>
        </div>
    @endif

    <div class="card-body d-flex flex-column mt-2">
        <h5 class="card-title fw-bold fs-4">{{ $product->title }}</h5>
        <p class="card-text text-muted small flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
        
        <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
            <span class="fs-4 fw-bold text-dark">{{ number_format($product->price, 2) }} €</span>
            {{-- Soporta tanto total_stock como stock normal --}}
            <span class="badge bg-success rounded-pill px-3 py-2">Stock: {{ $product->total_stock ?? $product->stock ?? 0 }}</span>
        </div>
    </div>
    
    <div class="card-footer bg-white border-0 pt-0 pb-4 px-3">
        
        @guest
            <a href="{{ route('login') }}" class="btn btn-outline-dark w-100 fw-bold rounded-pill">
                <i class="bi bi-box-arrow-in-right me-2"></i>Inicia sesión para comprar
            </a>
        @endguest

        @auth
            <form action="{{ route('orders.addProduct', $product) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark w-100 fw-bold rounded-pill mb-2 py-2">
                    <i class="bi bi-cart-plus me-2"></i>Añadir al carrito
                </button>
            </form>

            @if(Auth::user()->role_id == 1) 
                <div class="d-flex gap-2 mt-2 pt-2 border-top">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning btn-sm flex-fill fw-bold rounded-pill">
                        ✏️ Editar
                    </a>
                    
                    <form action="{{ route('products.delete', $product) }}" method="POST" class="flex-fill" onsubmit="return confirm('¿Estás seguro de que quieres aniquilar este producto?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-bold rounded-pill">
                            🗑️ Borrar
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</div>