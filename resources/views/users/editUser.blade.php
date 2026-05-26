@extends('layout')

@section('title', 'Editar Perfil')

@section('content')
<div class="min-h-screen bg-body-bg py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-primary px-6 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="bi bi-person-lines-fill"></i> Editar Perfil
                </h2>
                <p class="text-light text-sm mt-1">Actualiza tu información personal y credenciales de acceso.</p>
            </div>

            <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de usuario</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" autofocus
                            class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors">
                        @error('username') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors">
                        @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <hr class="border-gray-100 my-6">

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Seguridad</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña</label>
                            <input type="password" name="password" placeholder="Dejar en blanco para no cambiar"
                                class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors">
                            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar nueva contraseña</label>
                            <input type="password" name="password_confirmation" placeholder="Repite la nueva contraseña"
                                class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-colors">
                        </div>
                    </div>
                </div>

                @if(auth()->user()->roles->contains('id', 1))
                <div class="bg-red-50 p-4 rounded-lg border border-red-100 mt-6">
                    <h3 class="text-sm font-bold text-red-800 flex items-center gap-2 mb-3">
                        <i class="bi bi-shield-lock"></i> Zona de Administración (Asignación de Rol)
                    </h3>
                    <select name="role" class="w-full rounded-lg border-red-200 border px-4 py-2 text-red-900 bg-white focus:ring-2 focus:ring-red-500 outline-none">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                {{ strtoupper($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                @endif

                <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('users.show', $user->username) }}" class="px-6 py-2 text-gray-600 font-medium hover:text-gray-900 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-opacity-90 transition-all shadow-sm">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection