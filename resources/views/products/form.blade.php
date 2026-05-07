@extends('layout')

@section('title')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form method="POST" enctype="multipart/form-data" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}">
                @csrf
                @if($product->exists) @method('PUT') 
                    @section('title', 'Editar Producto')
                @endif
                @section('title', 'Crear Producto')

                <div class="form-group mb-3">
                    <label>Título</label>
                    <input name="title" class="form-control" value="{{ old('title', $product->title) }}">
                    @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Descripción</label>
                    <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                    @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Imagen del Producto</label>
                    <input type="file" name="image_url" class="form-control" accept="image/*">
                    @error('image_url') <div class="text-danger">{{ $message }}</div> @enderror
                    @if($product->exists && $product->image_url)
                        <div class="mt-2">
                            <small class="text-muted">Imagen actual:</small>
                            <img src="{{ asset($product->image_url) }}" alt="{{ $product->title }}" style="max-width: 150px; margin-top: 5px;">
                        </div>
                    @endif
                </div>
                
                <div class="form-group mb-3">
                    <label>Precio (€)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                    @error('price') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="fw-bold">Stock Total</label>
                    <input type="text" class="form-control bg-light" value="{{ $product->exists ? $product->total_stock : 0 }} uds" readonly>
                    <div class="form-text text-muted small">
                        * El stock total se calcula automáticamente sumando las cantidades de cada talla.
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="fw-bold mb-2">Categorías</label>
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" required
                                        {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $category->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('categories') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="form-group mb-4">
                <div class="form-group mb-4">
                    <label class="fw-bold m-0 mb-2">Tallas y Stock</label>
                    <div class="form-text text-muted mb-3">
                        Rellena el nombre y el stock. Deja en blanco las filas que no necesites. Para borrar una talla existente, simplemente borra su nombre.
                    </div>
                    
                    <div id="sizes-container">
                        @php 
                            $index = 0; 
                        @endphp

                        @if($product->exists)
                            @foreach($product->sizes as $size)
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <input type="text" name="sizes[{{ $index }}][name]" class="form-control form-control-sm" value="{{ $size->size }}" placeholder="Ej: 50x70, L, Única">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="sizes[{{ $index }}][stock]" class="form-control form-control-sm" value="{{ $size->stock }}" placeholder="Stock" min="0">
                                    </div>
                                </div>
                                @php $index++; @endphp
                            @endforeach
                        @endif

                        @for($i = 0; $i < 3; $i++)
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <input type="text" name="sizes[{{ $index }}][name]" class="form-control form-control-sm" value="" placeholder="Nueva talla (opcional)">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="sizes[{{ $index }}][stock]" class="form-control form-control-sm" value="0" placeholder="Stock" min="0">
                                </div>
                            </div>
                            @php $index++; @endphp
                        @endfor
                    </div>
                </div>

                <button class="btn btn-primary mt-2">{{ $product->exists ? 'Actualizar' : 'Crear Producto' }}</button>
            </form>
        </div>
    </div>
@endsection
