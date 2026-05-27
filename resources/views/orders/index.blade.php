@extends('adminLayout')
@section('title', 'Mis Pedidos')
@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <h2 class="text-3xl font-black text-dark tracking-tight">Mis Pedidos</h2>
        @if(auth()->user()->roles->contains('id', 1))
            <a href="{{ route('orders.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-dark text-white font-bold rounded-full hover:bg-opacity-90 transition-all shadow-sm">
                <i class="bi bi-plus-lg"></i> @lang('messages.neworder')
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-dark text-white p-4 rounded-xl text-sm font-bold mb-8 flex items-center justify-between shadow-lg js-alert">
            <div class="flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-success text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.closest('.js-alert').remove()" class="text-gray-400 hover:text-white transition-colors focus:outline-none">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm mt-4">
            <i class="bi bi-bag-x text-7xl text-gray-200 mb-6"></i>
            <h3 class="text-2xl font-bold text-dark mb-2">@lang('messages.no_orders')</h3>
            <p class="text-gray-500 mb-8">Aún no has realizado ninguna compra.</p>
            <a href="{{ route('home') }}" class="px-8 py-4 bg-white text-dark border-2 border-dark font-bold rounded-full uppercase tracking-widest text-sm hover:bg-dark hover:text-white transition-all">
                @lang('messages.store_go')
            </a>
        </div>
    @else
        <div class="flex flex-col gap-4">
            @foreach($orders as $order)
                <div class="bg-white border border-gray-100 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 flex-grow w-full md:w-auto">
                        <div class="md:border-r md:border-gray-100 pr-4">
                            <span class="block text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest mb-1">@lang('messages.reference')</span>
                            <span class="text-lg font-black text-dark">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div>
                            <span class="block text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest mb-1">@lang('messages.date')</span>
                            <span class="text-sm font-bold text-gray-700">{{ $order->created_at->format('d M, Y') }}</span>
                        </div>

                        <div>
                            <span class="block text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest mb-1">@lang('messages.total')</span>
                            <span class="text-lg font-black text-primary">{{ number_format($order->total_amount, 2) }} €</span>
                        </div>

                        <div>
                            <span class="block text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest mb-1">Estado</span>
                            @php
                                $statusStyles = match($order->status) {
                                    'completed', 'paid' => 'bg-green-50 text-green-700 border-green-200',
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'failed' => 'bg-red-50 text-red-700 border-red-200',
                                    default => 'bg-gray-50 text-gray-700 border-gray-200'
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full border text-xs font-black uppercase tracking-widest {{ $statusStyles }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-4 md:pt-0 border-t border-gray-100 md:border-t-0 w-full md:w-auto justify-end">
                        <a href="{{ route('orders.show', $order) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-500 hover:bg-dark hover:text-white transition-colors" title="Ver Detalles">
                            <i class="bi bi-eye"></i>
                        </a>
                        
                        @if(auth()->user()->roles->contains('id', 1))
                            <a href="{{ route('orders.edit', $order) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-colors" title="Editar Pedido">
                                <i class="bi bi-pencil"></i>
                            </a>
                            
                            <form method="POST" action="{{ route('orders.delete', $order) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este pedido por completo?');" class="m-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors" title="Eliminar">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection