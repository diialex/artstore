@extends('adminLayout')
@section('title', $category->exists ? 'Editar Categoría' : 'Nueva Categoría')

@section('content')
<div class="flex justify-center items-center w-full py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl w-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all">
        
        <div class="px-8 pt-10 pb-6 border-b border-gray-50 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-dark tracking-tight uppercase">{{ $category->exists ? 'Editar Categoría' : 'Nueva Categoría' }}</h2>
                <p class="text-sm text-gray-500 mt-1 font-medium">Gestiona las familias de productos</p>
            </div>
            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-400">
                <i class="bi bi-tags text-xl"></i>
            </div>
        </div>

        <form method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}" class="p-8 space-y-6">
            @csrf
            @if($category->exists) @method('PUT') @endif

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" autofocus placeholder="Ej. Camisetas"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                @error('name') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Descripción</label>
                <textarea name="description" rows="4" placeholder="Breve descripción de la colección..."
                          class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-y placeholder-gray-400">{{ old('description', $category->description) }}</textarea>
                @error('description') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('categories.index') }}" class="w-full sm:w-auto px-6 py-4 text-center text-gray-500 font-bold uppercase tracking-widest text-xs hover:text-dark hover:bg-gray-50 rounded-xl transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-dark text-white font-bold uppercase tracking-widest text-xs rounded-xl hover:bg-opacity-90 active:scale-95 transition-all shadow-sm flex items-center justify-center gap-2">
                    <i class="bi bi-save"></i> {{ $category->exists ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>
        
    </div>
</div>
@endsection