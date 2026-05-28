@extends('adminLayout')
@section('title', 'Crear Rol')

@section('content')
<div class="flex justify-center items-center w-full py-12 px-4 sm:px-6 lg:px-8">
    
    @if (session('msg'))
        <div class="fixed top-24 right-8 bg-dark text-white px-6 py-4 rounded-xl shadow-xl flex items-center gap-3 z-50 animate-fade-in-down js-alert">
            <i class="bi bi-check-circle-fill text-success"></i>
            <span class="text-sm font-bold">{{ session('msg') }}</span>
            <button onclick="this.closest('.js-alert').remove()" class="ml-4 text-gray-400 hover:text-white"><i class="bi bi-x-lg"></i></button>
        </div>
    @endif

    <div class="max-w-xl w-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all">
        <div class="px-8 pt-10 pb-6 border-b border-gray-50 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-dark tracking-tight uppercase">Nuevo Rol</h2>
                <p class="text-sm text-gray-500 mt-1 font-medium">Define niveles de acceso al sistema</p>
            </div>
            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-400">
                <i class="bi bi-shield-plus text-xl"></i>
            </div>
        </div>

        <form action="{{ route('roles.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nombre del Rol</label>
                <input type="text" name="name" value="{{ old('name') }}" autofocus placeholder="Ej. moderador"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                @error('name') <span class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i> Debes rellenar el nombre</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Descripción</label>
                <textarea name="description" rows="3" placeholder="Permisos y capacidades de este rol..."
                          class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-y placeholder-gray-400">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i> Debes incluir una descripción</span> @enderror
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('roles.index') }}" class="w-full sm:w-auto px-6 py-4 text-center text-gray-500 font-bold uppercase tracking-widest text-xs hover:text-dark hover:bg-gray-50 rounded-xl transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-dark text-white font-bold uppercase tracking-widest text-xs rounded-xl hover:bg-opacity-90 active:scale-95 transition-all shadow-sm flex items-center justify-center gap-2">
                    <i class="bi bi-save"></i> Crear Rol
                </button>
            </div>
        </form>
    </div>
</div>
@endsection