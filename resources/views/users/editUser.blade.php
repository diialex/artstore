@extends('layout')
@section('title', 'Editar Perfil')

@section('content')
<div class="flex justify-center items-center w-full py-12 px-4 sm:px-6 lg:px-8 mb-20">
    <div class="max-w-3xl w-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all">
        
        <div class="px-8 pt-10 pb-6 border-b border-gray-50 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-dark tracking-tight uppercase">Editar Perfil</h2>
                <p class="text-sm text-gray-500 mt-1 font-medium">Actualiza tu información personal y credenciales de acceso.</p>
            </div>
            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                <i class="bi bi-person-lines-fill text-2xl"></i>
            </div>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nombre de usuario</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" autofocus
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    @error('username') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    @error('name') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    @error('email') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Teléfono</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    @error('phone') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100">
                <h3 class="text-sm font-black text-dark uppercase tracking-widest mb-6">Seguridad</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nueva contraseña</label>
                        <input type="password" name="password" placeholder="Dejar en blanco para no cambiar"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                        @error('password') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" placeholder="Repite la nueva contraseña"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    </div>
                </div>
            </div>

            @if(auth()->user()->roles->contains('id', 1))
            <div class="bg-amber-50 p-6 rounded-2xl border border-amber-200 mt-6">
                <h3 class="text-xs font-black text-amber-800 uppercase tracking-widest flex items-center gap-2 mb-4">
                    <i class="bi bi-shield-lock-fill text-lg"></i> Asignación de Rol (Modo Admin)
                </h3>
                <div class="relative">
                    <select name="role" class="w-full appearance-none bg-white border border-amber-300 rounded-xl px-4 py-3.5 text-sm font-bold text-amber-900 focus:ring-2 focus:ring-amber-500 outline-none cursor-pointer pr-10">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                {{ strtoupper($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-amber-700">
                        <i class="bi bi-chevron-down text-xs"></i>
                    </div>
                </div>
                @error('role') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
            </div>
            @endif

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('users.show', $user->username) }}" class="w-full sm:w-auto px-6 py-4 text-center text-gray-500 font-bold uppercase tracking-widest text-xs hover:text-dark hover:bg-gray-50 rounded-xl transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-primary text-white font-bold uppercase tracking-widest text-xs rounded-xl hover:bg-opacity-90 active:scale-95 transition-all shadow-sm flex items-center justify-center gap-2">
                    <i class="bi bi-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection