@extends('layout')

@section('title', 'Mis Direcciones')

@section('content')
<div class="min-h-screen bg-body-bg py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        
        @if (session('msg'))
            <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between animate__fadeInDown">
                <div class="flex items-center text-green-800">
                    <i class="bi bi-check-circle-fill mr-3 text-xl"></i>
                    <p class="font-medium">{{ session('msg') }}</p>
                </div>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4 border-b border-gray-200 pb-4">
            <h2 class="text-3xl font-bold text-dark flex items-center gap-3">
                <i class="bi bi-geo-alt-fill text-primary"></i> Mis Direcciones
            </h2>
            <a href="{{ route('addresses.create', isset($userId) ? ['user_id' => $userId] : []) }}" 
               class="inline-flex items-center justify-center bg-primary text-white px-6 py-2.5 rounded-full font-medium hover:bg-opacity-90 hover:shadow-md hover:-translate-y-0.5 transition-all">
                <i class="bi bi-plus-lg mr-2"></i> Nueva dirección
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            @forelse($addresses as $address)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:border-primary hover:shadow-md transition-all group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                <i class="bi bi-house-door-fill mr-1"></i> Casa / Envío
                            </span>
                            <span class="text-xs text-gray-400 flex items-center gap-1">
                                <i class="bi bi-person"></i> {{ $address->user->username ?? 'Sin usuario' }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-2 leading-tight">
                            {{ $address->street }}
                        </h3>
                        <p class="text-gray-600 mb-1 flex items-center gap-2">
                            <i class="bi bi-building text-gray-400"></i> {{ $address->city }}
                        </p>
                        <p class="text-gray-500 font-medium flex items-center gap-2">
                            <i class="bi bi-mailbox text-gray-400"></i> C.P: {{ $address->zip_code }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-50">
                        <a href="{{ route('addresses.edit', $address->id) }}" class="flex-1 bg-gray-50 text-gray-700 text-center py-2.5 rounded-xl font-medium hover:bg-blue-50 hover:text-blue-700 transition-colors border border-gray-100 hover:border-blue-200">
                            <i class="bi bi-pencil-square mr-1"></i> Editar
                        </a>
                        
                        <form action="{{ route('addresses.delete', $address->id) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta dirección de envío?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-600 py-2.5 rounded-xl font-medium hover:bg-red-600 hover:text-white transition-colors border border-red-100 hover:border-red-600">
                                <i class="bi bi-trash3 mr-1"></i> Borrar
                            </button>
                        </form>
                    </div>
                </div>
                
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-geo text-gray-300 text-4xl block"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Aún no tienes direcciones guardadas</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">Añade una dirección de envío para que tus futuros pedidos lleguen volando a la puerta de tu casa.</p>
                    <a href="{{ route('addresses.create', isset($userId) ? ['user_id' => $userId] : []) }}" class="inline-block bg-primary text-white px-8 py-3 rounded-full font-medium hover:bg-opacity-90 transition-all hover:shadow-lg">
                        Añadir mi primera dirección
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection