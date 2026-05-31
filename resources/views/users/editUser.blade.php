@extends('layout')
@section('title', 'Editar Perfil')

@section('content')
<div class="flex justify-center items-center w-full py-12 px-4 sm:px-6 lg:px-8 mb-20">
    <div class="max-w-3xl w-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all">
        
        <div class="px-8 pt-10 pb-6 border-b border-gray-50 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-dark tracking-tight uppercase">@lang('messages.edit_profile')</h2>
                <p class="text-sm text-gray-500 mt-1 font-medium">@lang('messages.update_personal_info')</p>
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
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.username')</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" autofocus
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    @error('username') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.name_completo')</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    @error('name') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.email')</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    @error('email') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.phone')</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    @error('phone') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100">
                <h3 class="text-sm font-black text-dark uppercase tracking-widest mb-6">@lang('messages.security')</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.newpass')</label>
                        <input type="password" name="password" placeholder="Dejar en blanco para no cambiar"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                        @error('password') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.confirm_password')</label>
                        <input type="password" name="password_confirmation" placeholder="Repite la nueva contraseña"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    </div>
                </div>
            </div>

            @if(auth()->user()->roles->contains('id', 1))
                <div class="mt-6 p-6 bg-gray-50 rounded-xl border border-gray-200">
                    <label for="role" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        @lang('messages.rol_asignation')
                    </label>
                    
                    <select id="role" name="role" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                        
                        @foreach($roles as $rolDisponible)
                            <option value="{{ $rolDisponible->id }}" 
                                {{ $user->roles->contains('id', $rolDisponible->id) ? 'selected' : '' }}>
                                {{ strtoupper($rolDisponible->name) }}
                            </option>
                        @endforeach

                    </select>
                </div>
            @endif

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                
                <button type="button" onclick="window.history.back();" class="w-full sm:w-auto px-6 py-4 text-center text-gray-500 font-bold uppercase tracking-widest text-xs hover:text-dark hover:bg-gray-50 rounded-xl transition-colors">
                    Cancelar
                </button>

                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-primary text-white font-bold uppercase tracking-widest text-xs rounded-xl hover:bg-opacity-90 active:scale-95 transition-all shadow-sm flex items-center justify-center gap-2">
                    <i class="bi bi-save"></i> @lang('messages.save_changes')
                </button>
            </div>
        </form>
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-bold">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection