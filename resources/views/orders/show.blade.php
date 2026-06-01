@extends('layout')
@section('title', __('messages.orderdetails'))

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full mb-20">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 border-b border-gray-200 pb-6">
        <div class="flex items-center gap-4">
            <button onclick="window.history.back();" class="text-gray-400 hover:text-dark transition-colors focus:outline-none">
                <i class="bi bi-arrow-left text-2xl"></i>
            </button>
            
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-dark tracking-tight uppercase flex items-center gap-3">
                    Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    
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
                </h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">@lang('messages.order_did') {{ $order->created_at->format('d de F, Y \a \l\a\s H:i') }}</p>
            </div>
        </div>
        
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-full hover:bg-gray-50 hover:text-dark transition-all active:scale-95 shadow-sm text-sm uppercase tracking-widest">
            <i class="bi bi-printer"></i> @lang('messages.print_receipt')
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest">@lang('messages.bought_articles')</h3>
                    <span class="text-xs font-bold text-gray-400">{{ $order->items->count() }} artículo(s)</span>
                </div>
                
                <div class="divide-y divide-gray-50">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-6 p-6 hover:bg-gray-50/30 transition-colors">
                            
                            <div class="w-20 h-24 shrink-0 bg-gray-100 rounded-xl overflow-hidden">
                                @if($item->product->image_url)
                                    <img src="{{ asset($item->product->image_url) }}" class="w-full h-full object-cover" alt="{{ $item->product->title }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="bi bi-camera text-2xl"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-grow">
                                <h4 class="font-bold text-dark text-lg mb-1">{{ $item->product->title }}</h4>
                                <div class="flex flex-wrap gap-4 text-sm">
                                    <span class="text-gray-500 font-medium">@lang('messages.size'): <span class="text-dark font-bold">{{ $item->size->size ?? __('messages.unique') }}</span></span>
                                    <span class="text-gray-500 font-medium">@lang('messages.amnt'): <span class="text-dark font-bold">{{ $item->quantity }}</span></span>
                                </div>
                            </div>

                            <div class="text-right shrink-0">
                                <span class="text-lg font-black text-dark">{{ number_format($item->price * $item->quantity, 2) }} €</span>
                                @if($item->quantity > 1)
                                    <span class="block text-xs text-gray-400 font-medium mt-1">{{ number_format($item->price, 2) }} € / ud</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            
            <div class="bg-gray-50 rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest border-b border-gray-200 pb-4 mb-6">@lang('messages.pay_summary')</h3>
                
                <div class="space-y-4 mb-6 text-sm font-medium">
                    <div class="flex justify-between text-gray-600">
                        <span>@lang('messages.subtot')</span>
                        <span>{{ number_format($order->total_amount, 2) }} €</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>@lang('messages.send_waste')</span>
                        <span class="text-success font-bold uppercase tracking-wide">.@lang('messages.free')</span>
                    </div>
                </div>
                
                <div class="flex justify-between items-end pt-6 border-t border-gray-200">
                    <span class="text-lg font-black uppercase tracking-widest text-dark">@lang('messages.total')</span>
                    <span class="text-3xl font-black text-dark">{{ number_format($order->total_amount, 2) }} €</span>
                </div>
            </div>

            @if($order->address)
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-full flex items-center justify-center">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h3 class="text-sm font-black text-dark uppercase tracking-widest">@lang('messages.sendaddress')</h3>
                </div>
                
                <div class="text-sm font-medium text-gray-600 space-y-1 pl-13">
                    <p class="font-bold text-dark text-base mb-2">{{ $order->user->name ?? $order->user->username }}</p>
                    <p>{{ $order->address->street }}</p>
                    <p>{{ $order->address->city }}, {{ $order->address->zip_code }}</p>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<style>
    @media print {
        header, footer, nav, button { display: none !important; }
        body { background-color: white !important; }
        .max-w-\[1400px\] { max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
        .shadow-sm, .shadow-lg { box-shadow: none !important; }
        .border-gray-100 { border-color: #e5e7eb !important; }
    }
</style>
@endsection