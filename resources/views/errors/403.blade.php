@extends('layout')
@section('title', 'Acceso no permitido')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[70vh] px-4 py-12 w-full text-center">
    
    <div class="w-32 h-32 bg-red-50 rounded-full flex items-center justify-center mb-8 shadow-inner border-4 border-white">
        <i class="bi bi-slash-circle text-7xl text-red-500 drop-shadow-sm"></i>
    </div>
    
    <h1 class="text-4xl md:text-5xl font-black text-dark tracking-widest uppercase mb-4">@lang('messages.unauthorized')</h1>
    
    <p class="text-gray-500 mb-10 max-w-lg font-medium leading-relaxed">
        @lang('messages.no_permit')
    </p>
    
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-dark text-white font-bold uppercase tracking-widest px-8 py-4 rounded-full hover:bg-opacity-90 transition-all shadow-md active:scale-95">
        <i class="bi bi-house-door text-lg"></i> @lang('messages.back_start')
    </a>
    
</div>
@endsection