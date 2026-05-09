<div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm">

        @if($product->image_url)
            <img src="{{ asset('storage/' . $product->image_url) }}" class="card-img-top border-bottom"
                alt="{{ $product->title }}" style="height: 220px; object-fit: cover;">
        @else
            <div class="card-img-top bg-light d-flex align-items-center justify-content-center text-muted border-bottom"
                style="height: 220px;">
                <span>📸 Sin imagen</span>
            </div>
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $product->title }}</h5>
            <p class="card-text text-muted">{{ Str::limit($product->description, 80) }}</p>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="h5 text-primary mb-0">{{ $product->price }} €</span>
                <span class="badge bg-secondary">Stock: {{ $product->total_stock }}</span>
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between">
            @if(auth()->user()->roles->contains('id', 1))

                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning btn-sm">
                    ✏️ Editar
                </a>

                <form action="{{ route('products.delete', $product) }}" method="POST"
                    onsubmit="return confirm('¿Estás seguro de que quieres aniquilar este producto?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        🗑️ Borrar
                    </button>
                    <!-- Usuario tiene rol 1 o 2 -->
            @endif

            @if (auth()->user()->roles->contains('id', 2))
                <a href="{{ route('orders.carrito', $product) }}" class="btn btn-outline-warning btn-sm">
                    Añadir al carrito
                </a>
                <a href="{{ route('orders.carrito', $product) }}" class="btn btn-outline-warning btn-sm" title="Añadir a favoritos">
                    ❤
                </a>
            @endif
            </form>

        </div>
    </div>
</div>