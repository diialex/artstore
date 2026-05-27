@extends('auth.template')

@section('content')
<div class="flex justify-center items-center w-full py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all">
        
        <div class="px-8 pt-10 pb-6 text-center border-b border-gray-50">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary bg-opacity-10 mb-4 text-primary shadow-inner">
                <i class="bi bi-person-plus text-3xl"></i>
            </div>
            <h2 class="text-2xl font-black text-dark tracking-tight">Crear Cuenta</h2>
            <p class="text-sm text-gray-500 mt-2">Únete a Hanger y gestiona tus pedidos</p>
        </div>

        <div class="px-8 py-8">
            
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium mb-6 border border-red-100">
                    <ul class="list-disc list-inside flex flex-col gap-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nombre Completo</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    </div>

                    <div>
                        <label for="username" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nombre de Usuario</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Teléfono</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Contraseña</label>
                        <input type="password" id="password" name="password" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Confirmar Contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    </div>

                </div>

                <button type="submit" class="w-full mt-2 bg-dark text-white font-bold uppercase tracking-widest py-4 rounded-xl hover:bg-opacity-90 hover:shadow-lg transition-all active:scale-95 flex justify-center items-center gap-2">
                    <i class="bi bi-person-check text-lg"></i> Registrarse
                </button>

                <div class="mt-4 text-center">
                    <span class="text-xs font-medium text-gray-500">¿Ya tienes cuenta?</span>
                    <a href="{{ route('login') }}" class="text-xs font-bold text-primary hover:text-dark transition-colors uppercase tracking-widest ml-1">
                        Inicia sesión aquí
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection