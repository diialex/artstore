@extends('adminLayout')
@section('title', 'Crear Usuario')

@section('content')
<div class="flex justify-center items-center w-full py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all">
        
        <div class="px-8 pt-10 pb-6 border-b border-gray-50 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-dark tracking-tight uppercase">Nuevo Usuario</h2>
                <p class="text-sm text-gray-500 mt-1 font-medium">Añade manualmente un cliente o administrador</p>
            </div>
            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-400">
                <i class="bi bi-person-plus text-xl"></i>
            </div>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" autofocus placeholder="Ej. juanperez99"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    @error('username') <span class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nombre Completo</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej. Juan Pérez"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    @error('name') <span class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    @error('email') <span class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+34 600 000 000"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    @error('phone') <span class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    @error('password') <span class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Asignar Roles</label>
                <div class="grid grid-cols-2 gap-4 p-5 bg-gray-50 rounded-2xl border border-gray-200">
                    @foreach($roles as $role)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                   {{ (is_array(old('roles')) && in_array($role->id, old('roles'))) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-gray-300 text-dark focus:ring-dark transition-all">
                            <span class="text-sm font-bold text-gray-700 group-hover:text-dark transition-colors">{{ uppercase($role->name) }}</span>
                        </label>
                    @endforeach
                </div>
                @error('roles') <span class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i> Selecciona al menos un rol</span> @enderror
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('users.index') }}" class="w-full sm:w-auto px-6 py-4 text-center text-gray-500 font-bold uppercase tracking-widest text-xs hover:text-dark hover:bg-gray-50 rounded-xl transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-dark text-white font-bold uppercase tracking-widest text-xs rounded-xl hover:bg-opacity-90 active:scale-95 transition-all shadow-sm flex items-center justify-center gap-2">
                    <i class="bi bi-save"></i> Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection