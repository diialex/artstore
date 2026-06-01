@extends('layout')
@section('title', __('messages.purchase_success_title'))

@section('content')
<div class="max-w-[700px] mx-auto px-4 sm:px-6 py-16 w-full mb-20">

    <div class="bg-white border border-gray-100 rounded-2xl shadow-xl overflow-hidden">

        <div class="bg-primary px-8 py-10 text-center">
            <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg mb-5">
                <i class="bi bi-check-lg text-primary text-5xl"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight uppercase">
                @lang('messages.purchase_success_title')
            </h1>
            <p class="text-light/90 text-sm mt-3">
                @lang('messages.purchase_success_subtitle')
            </p>
        </div>

        <div class="px-8 py-10">

            <div class="flex flex-col sm:flex-row gap-4 mb-8">
                <div class="flex-1 bg-gray-50 border border-gray-100 rounded-xl p-5 text-center">
                    <p class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-2">@lang('messages.order_label')</p>
                    <p class="text-lg font-black text-dark">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="flex-1 bg-gray-50 border border-gray-100 rounded-xl p-5 text-center">
                    <p class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-2">@lang('messages.total_paid')</p>
                    <p class="text-lg font-black text-primary">{{ number_format($total ?? $order->total_amount, 2) }} €</p>
                </div>
            </div>

            @if(!empty($stockIssues))
                <div class="flex items-start gap-3 bg-amber-50 rounded-xl p-5 border border-amber-200 mb-8">
                    <i class="bi bi-exclamation-triangle-fill text-amber-500 text-2xl shrink-0"></i>
                    <div class="text-sm text-amber-800">
                        <p class="font-bold mb-1">Incidencia con el stock</p>
                        <p>Mientras completabas el pago, alguno de los artículos se agotó. Tu pago se ha registrado y nuestro equipo se pondrá en contacto contigo para resolverlo (reposición o reembolso):</p>
                        <ul class="list-disc list-inside mt-2">
                            @foreach($stockIssues as $issue)
                                <li>{{ $issue['product'] }}@if($issue['size']) ({{ $issue['size'] }})@endif — pedidas {{ $issue['requested'] }}, disponibles {{ $issue['available'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="flex items-start gap-3 bg-light rounded-xl p-5 border border-primary/10 mb-8">
                <i class="bi bi-envelope-check text-primary text-2xl shrink-0"></i>
                <p class="text-sm text-gray-600">
                    @lang('messages.purchase_email_sent')
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('orders.show', $order->id) }}"
                   class="flex-1 bg-primary text-white font-bold uppercase tracking-widest text-center py-4 rounded-lg transition-all shadow-md active:scale-95 hover:opacity-90">
                    @lang('messages.view_my_order')
                </a>
                <a href="{{ route('home') }}"
                   class="flex-1 bg-white text-primary border-2 border-primary font-bold uppercase tracking-widest text-center py-4 rounded-lg transition-all active:scale-95 hover:bg-light">
                    @lang('messages.continue_shopping')
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
