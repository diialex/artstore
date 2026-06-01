@extends('adminLayout') @section('title', $order->id ? __('messages.editorder') : __('messages.neworder'))

@section('content')
<div class="w-full max-w-[800px] mx-auto px-4 sm:px-6 py-12 mb-20">
    
    <div class="mb-8">
        <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 hover:text-primary transition-colors mb-4">
            <i class="bi bi-arrow-left"></i> Volver a Pedidos
        </a>
        <h2 class="text-3xl font-black text-dark tracking-tight uppercase">
            {{ $order->id ? __('messages.editorder') : __('messages.neworder') }}
        </h2>
        @if($order->id)
            <p class="text-gray-500 text-sm mt-1 font-medium">Gestionando el pedido #{{ $order->id }}</p>
        @endif
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-10">
        <form action="{{ $order->id ? route('orders.update', $order) : route('orders.store') }}" method="POST" class="flex flex-col gap-6">
            @csrf
            @if($order->id)
                @method('PUT')
            @endif

            <div class="flex flex-col gap-2">
                <label for="total_amount" class="text-sm font-bold text-gray-700 tracking-wide uppercase">@lang('messages.total_amount')</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">$</span>
                    <input type="number" step="0.01" id="total_amount" name="total_amount" 
                        value="{{ old('total_amount', $order->total_amount) }}"
                        class="w-full pl-8 pr-4 py-3 rounded-xl border {{ $errors->has('total_amount') ? 'border-red-300 focus:ring-red-200' : 'border-gray-200 focus:border-primary focus:ring-primary/20' }} focus:ring-4 outline-none transition-all font-medium text-dark bg-gray-50 focus:bg-white" 
                        placeholder="0.00">
                </div>
                @error('total_amount')
                    <span class="text-xs font-bold text-red-500 mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="status" class="text-sm font-bold text-gray-700 tracking-wide uppercase">@lang('messages.status')</label>
                <div class="relative">
                    <select id="status" name="status" 
                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('status') ? 'border-red-300 focus:ring-red-200' : 'border-gray-200 focus:border-primary focus:ring-primary/20' }} focus:ring-4 outline-none transition-all font-medium text-dark bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                        <option value="" class="text-gray-400">@lang('messages.select_state')</option>
                        <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>@lang('messages.pending')</option>
                        <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>@lang('messages.completed')</option>
                        <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>@lang('messages.cancelled')</option>
                    </select>
                    <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
                @error('status')
                    <span class="text-xs font-bold text-red-500 mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="shipping_address" class="text-sm font-bold text-gray-700 tracking-wide uppercase">@lang('messages.sendaddress')</label>
                <div class="relative">
                    <i class="bi bi-geo-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="shipping_address" name="shipping_address" 
                        value="{{ old('shipping_address', $order->shipping_address) }}"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $errors->has('shipping_address') ? 'border-red-300 focus:ring-red-200' : 'border-gray-200 focus:border-primary focus:ring-primary/20' }} focus:ring-4 outline-none transition-all font-medium text-dark bg-gray-50 focus:bg-white" 
                        placeholder="Ej: Calle Principal 123, Ciudad">
                </div>
                @error('shipping_address')
                    <span class="text-xs font-bold text-red-500 mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="w-full h-px bg-gray-100 my-2"></div>

            <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-2">
                <a href="{{ route('orders.index') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl text-gray-500 font-bold hover:bg-gray-50 transition-colors text-center">
                    @lang('messages.cancel')
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-primary text-white font-black tracking-wide hover:bg-opacity-90 hover:-translate-y-0.5 transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                    <i class="bi {{ $order->id ? 'bi-save' : 'bi-plus-lg' }}"></i>
                    {{ $order->id ? __('messages.update') : __('messages.crear') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection