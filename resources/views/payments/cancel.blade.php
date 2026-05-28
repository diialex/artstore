@extends('layout')
@section('title', 'Pago Cancelado')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh] px-4 py-12 w-full">
    
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 sm:p-12 text-center">
        
        <div class="w-28 h-28 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner border-4 border-white">
            <i class="bi bi-x-circle-fill text-7xl text-red-500 drop-shadow-sm"></i>
        </div>
        
        <h1 class="text-3xl font-black text-dark tracking-tight uppercase mb-4">@lang('messages.payment_cancelled')</h1>
        
        <p class="text-gray-500 mb-10 font-medium leading-relaxed">
            No te preocupes, el proceso se ha interrumpido de forma segura y <strong>no se ha realizado ningún cargo</strong> en tu cuenta. Puedes volver a intentarlo cuando estés listo.
        </p>
        
        <div class="flex flex-col gap-4">
            <a href="{{ route('orders.carrito') }}" class="w-full flex justify-center items-center gap-2 bg-[#212529] text-white font-bold uppercase tracking-widest py-4 rounded-xl hover:bg-opacity-90 transition-all shadow-md active:scale-95">
                <i class="bi bi-arrow-left text-lg"></i> Volver al carrito
            </a>
            
            <a href="{{ route('home') }}" class="w-full flex justify-center items-center gap-2 bg-gray-50 text-gray-600 border border-gray-200 font-bold uppercase tracking-widest py-4 rounded-xl hover:bg-gray-100 hover:text-dark transition-all active:scale-95">
                Ir al inicio
            </a>
        </div>
    </div>
    
</div>
@endsection