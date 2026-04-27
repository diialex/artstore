<x-layout>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form method="POST" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}">
                @csrf
                @if($product->exists) @method('PUT') @endif

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
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $category->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('categories') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="form-group mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <label class="fw-bold m-0">Tallas y Stock</label>
            <button type="button" class="btn btn-sm btn-outline-success" onclick="addSizeRow()">➕ Añadir Talla</button>
        </div>
    
        <div id="sizes-container">
            @if($product->exists)
                @foreach($product->sizes as $index => $size)
                    <div class="row g-2 mb-2 size-row">
                        <div class="col-5">
                            <input type="text" name="sizes[{{ $index }}][name]" class="form-control form-control-sm" value="{{ $size->size }}" placeholder="Ej: 50x70, L, Única" required>
                        </div>
                        <div class="col-5">
                            <input type="number" name="sizes[{{ $index }}][stock]" class="form-control form-control-sm" value="{{ $size->stock }}" placeholder="Stock" min="0" required>
                        </div>
                        <div class="col-2 text-end">
                            <button type="button" class="btn btn-sm btn-danger w-100" onclick="this.closest('.size-row').remove()">❌</button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Uy! Hay un problema con los datos:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script>
        let sizeIndex = {{ $product->exists ? $product->sizes->count() : 0 }};
        
        function addSizeRow() {
            const container = document.getElementById('sizes-container');
            const row = document.createElement('div');
            row.className = 'row g-2 mb-2 size-row';
            row.innerHTML = `
                <div class="col-5">
                    <input type="text" name="sizes[${sizeIndex}][name]" class="form-control form-control-sm" placeholder="Ej: 50x70, L, Única" required>
                </div>
                <div class="col-5">
                    <input type="number" name="sizes[${sizeIndex}][stock]" class="form-control form-control-sm" placeholder="Stock" min="0" value="0" required>
                </div>
                <div class="col-2 text-end">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="this.closest('.size-row').remove()">❌</button>
                </div>
            `;
            container.appendChild(row);
            sizeIndex++;
        }
    </script>

                <button class="btn btn-primary mt-2">{{ $product->exists ? 'Actualizar' : 'Crear Producto' }}</button>
            </form>
        </div>
    </div>
</x-layout>