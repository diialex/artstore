<x-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestión de Productos</h2>
            <a href="{{ route('products.create') }}" class="btn btn-success">➕ Crear Nuevo</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h5 text-primary mb-0">{{ $product->price }} €</span>
                                <span class="badge bg-secondary">Stock: {{ $product->stock }}</span>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white d-flex justify-content-between">
                            
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning btn-sm">
                                ✏️ Editar
                            </a>

                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres aniquilar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    🗑️ Borrar
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($products, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-layout>