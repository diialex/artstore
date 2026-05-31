@extends('layout')
@section('title', 'Mis Direcciones')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full mb-20">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('users.show', auth()->user()->username) }}" class="text-gray-400 hover:text-dark transition-colors mr-2">
                <i class="bi bi-arrow-left text-xl"></i>
            </a>
            <h2 class="text-3xl font-black text-dark tracking-tight uppercase">@lang('messages.my_addresses')</h2>
        </div>
        <a href="{{ route('addresses.create', isset($userId) ? ['user_id' => $userId] : []) }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-dark text-white font-bold rounded-full hover:bg-opacity-90 transition-all shadow-sm active:scale-95">
            <i class="bi bi-plus-lg"></i> @lang('messages.newaddress')
        </a>
    </div>

    @if (session('msg'))
        <div class="bg-dark text-white p-4 rounded-xl text-sm font-bold mb-8 flex items-center justify-between shadow-lg js-alert">
            <div class="flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-success text-lg"></i>
                <span>{{ session('msg') }}</span>
            </div>
            <button onclick="this.closest('.js-alert').remove()" class="text-gray-400 hover:text-white transition-colors focus:outline-none">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @forelse($addresses as $address)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 flex flex-col justify-between hover:shadow-md transition-shadow group relative overflow-hidden">
                
                <div class="absolute top-0 right-0 w-24 h-24 bg-gray-50 rounded-bl-full -z-10 group-hover:bg-primary/5 transition-colors"></div>

                <div>
                    <div class="flex items-center justify-between mb-6">
                        <span class="bg-gray-100 text-dark text-[0.65rem] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest flex items-center gap-1.5">
                            <i class="bi bi-house-door-fill"></i> @lang('messages.ship')
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-black text-dark mb-3 leading-tight uppercase">
                        {{ $address->street }}
                    </h3>
                    <p class="text-gray-500 font-medium mb-1 flex items-center gap-2 text-sm">
                        <i class="bi bi-building text-gray-400"></i> {{ $address->city }}
                    </p>
                    <p class="text-gray-500 font-medium flex items-center gap-2 text-sm">
                        <i class="bi bi-mailbox text-gray-400"></i> C.P: {{ $address->zip_code }}
                    </p>
                </div>

                <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('addresses.edit', $address->id) }}" class="flex-1 bg-gray-50 text-dark text-center py-3 rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-dark hover:text-white transition-colors">
                        @lang('messages.edit')
                    </a>
                    
                    <form action="{{ route('addresses.delete', $address->id) }}" method="POST" class="flex-1 m-0" onsubmit="return confirm('¿Seguro que deseas eliminar esta dirección?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-50 text-red-600 text-center py-3 rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-red-600 hover:text-white transition-colors">
                            @lang('messages.delete')
                        </button>
                    </form>
                </div>
            </div>
            
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
                <i class="bi bi-geo text-7xl text-gray-200 mb-6"></i>
                <h3 class="text-2xl font-bold text-dark mb-2">@lang('messages.no_address')</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto text-center">@lang('messages.ship_msg')</p>
                <a href="{{ route('addresses.create', isset($userId) ? ['user_id' => $userId] : []) }}" class="px-8 py-4 bg-white text-dark border-2 border-dark font-bold rounded-full uppercase tracking-widest text-sm hover:bg-dark hover:text-white transition-all active:scale-95">
                    @lang('messages.first_address')
                </a>
            </div>
        @endforelse

    </div>
</div>
@endsection