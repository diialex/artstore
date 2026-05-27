@extends('layout')

@section('title', 'Mi Perfil | ' . $user->username)

@section('content')
<div class="min-h-screen bg-body-bg py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-3xl mx-auto">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="bg-primary px-6 py-8 sm:p-10">
                <div class="flex items-center gap-6">
                    <div class="h-24 w-24 bg-white rounded-full flex items-center justify-center text-primary shadow-md">
                        <i class="bi bi-person-fill text-5xl"></i>
                    </div>
                    
                    <div>
                        <h1 class="text-3xl font-bold text-white tracking-tight">
                            @lang('messages.hello'), {{ $user->name ?? $user->username }}!
                        </h1>
                        <p class="text-light mt-1 flex items-center gap-2">
                            <i class="bi bi-envelope"></i> {{ $user->email }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-8 sm:p-10 bg-white">
                <h3 class="text-lg font-semibold text-dark mb-6 border-b pb-2">
                    @lang('messages.account_options')
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <a href="{{ route('users.edit', $user->username) }}" 
                       class="group flex items-center p-4 bg-white rounded-xl border border-gray-200 hover:border-primary hover:bg-light transition-all duration-200">
                        <div class="h-10 w-10 bg-body-bg rounded-lg shadow-sm flex items-center justify-center text-dark group-hover:text-primary mr-4">
                            <i class="bi bi-pencil-square text-xl"></i>
                        </div>
                        <div>
                            <p class="font-medium text-dark">Editar Perfil</p>
                            <p class="text-sm text-gray-500">Actualiza tus datos personales</p>
                        </div>
                    </a>

                    <a href="{{ route('orders.index') }}" 
                       class="group flex items-center p-4 bg-white rounded-xl border border-gray-200 hover:border-primary hover:bg-light transition-all duration-200">
                        <div class="h-10 w-10 bg-body-bg rounded-lg shadow-sm flex items-center justify-center text-dark group-hover:text-primary mr-4">
                            <i class="bi bi-bag text-xl"></i>
                        </div>
                        <div>
                            <p class="font-medium text-dark">@lang('messages.orders')</p>
                            <p class="text-sm text-gray-500">Revisa tu historial de compras</p>
                        </div>
                    </a>

                    <a href="{{ route('addresses.show', $user->username) }}" 
                       class="group flex items-center p-4 bg-white rounded-xl border border-gray-200 hover:border-primary hover:bg-light transition-all duration-200">
                        <div class="h-10 w-10 bg-body-bg rounded-lg shadow-sm flex items-center justify-center text-dark group-hover:text-primary mr-4">
                            <i class="bi bi-geo-alt text-xl"></i>
                        </div>
                        <div>
                            <p class="font-medium text-dark">Mis Direcciones</p>
                            <p class="text-sm text-gray-500">Gestiona dónde enviamos tu ropa</p>
                        </div>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection