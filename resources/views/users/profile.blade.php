@extends('layout')
@section('title', 'Mi Perfil | ' . $user->username)

@section('content')
<div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 mb-20">
    
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="bg-primary px-8 py-10 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 relative z-10">
                    <div class="h-28 w-28 bg-white rounded-full flex items-center justify-center text-primary shadow-lg border-4 border-white/20">
                        <i class="bi bi-person-fill text-6xl"></i>
                    </div>
                    
                    <div class="text-center sm:text-left mt-2">
                        <h1 class="text-3xl md:text-4xl font-black text-white tracking-widest uppercase">
                            @lang('messages.hello'), {{ $user->name ?? $user->username }}!
                        </h1>
                        <p class="text-light mt-2 flex items-center justify-center sm:justify-start gap-2 text-sm font-medium opacity-90">
                            <i class="bi bi-envelope"></i> {{ $user->email }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-8 sm:p-10 bg-gray-50/50">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-200 pb-3">
                    @lang('messages.account_options')
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <a href="{{ route('users.edit', $user->username) }}" 
                       class="group flex items-center p-5 bg-white rounded-2xl border border-gray-200 hover:border-primary hover:shadow-md transition-all duration-300">
                        <div class="h-12 w-12 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors mr-5">
                            <i class="bi bi-pencil-square text-2xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-dark text-lg">Editar Perfil</p>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">Actualiza tus datos personales</p>
                        </div>
                    </a>

                    <a href="{{ route('orders.index') }}" 
                       class="group flex items-center p-5 bg-white rounded-2xl border border-gray-200 hover:border-primary hover:shadow-md transition-all duration-300">
                        <div class="h-12 w-12 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors mr-5">
                            <i class="bi bi-bag text-2xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-dark text-lg">@lang('messages.orders')</p>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">Revisa tu historial de compras</p>
                        </div>
                    </a>

                    <a href="{{ route('addresses.show', $user->username) }}" 
                       class="group flex items-center p-5 bg-white rounded-2xl border border-gray-200 hover:border-primary hover:shadow-md transition-all duration-300">
                        <div class="h-12 w-12 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors mr-5">
                            <i class="bi bi-geo-alt text-2xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-dark text-lg">Mis Direcciones</p>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">Gestiona dónde enviamos tu ropa</p>
                        </div>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection