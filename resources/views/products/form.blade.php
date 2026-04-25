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

                <div class="form-group mb-3">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock ?? 0) }}">
                    @error('stock') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary mt-2">{{ $product->exists ? 'Actualizar' : 'Crear Producto' }}</button>
            </form>
        </div>
    </div>
</x-layout>