@extends('layout')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestión de Productos</h2>
            <div class="card bg-light mb-4 shadow-sm">
            <div class="card-body py-2">
                    <form action="{{ route('products.index') }}" method="GET" class="row align-items-center">
                        <div class="col-auto">
                            <label for="category" class="col-form-label fw-bold">Filtrar por Categoría:</label>
                        </div>
                        <div class="col-auto">
                            <select name="category" id="category" class="form-select" onchange="this.form.submit()">
                                <option value="">Todas las categorías</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if(request('category'))
                            <div class="col-auto">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">❌ Limpiar filtro</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
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
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h5 text-primary mb-0">{{ $product->price }} €</span>
                                <span class="badge bg-secondary">Stock: {{ $product->total_stock }}</span>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white d-flex justify-content-between">
                            
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning btn-sm">
                                ✏️ Editar
                            </a>

                            <form action="{{ route('products.delete', $product) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres aniquilar este producto?');">
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