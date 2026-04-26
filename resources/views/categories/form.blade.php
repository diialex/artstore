<x-layout>
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">{{ $category->exists ? 'Editar Categoría' : 'Nueva Categoría' }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
                        @csrf
                        @if($category->exists) @method('PUT') @endif

                        <div class="form-group mb-3">
                            <label class="fw-bold">Nombre</label>
                            <input name="name" class="form-control" value="{{ old('name', $category->name) }}">
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-bold">Descripción</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
                            @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">{{ $category->exists ? 'Actualizar' : 'Guardar' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>