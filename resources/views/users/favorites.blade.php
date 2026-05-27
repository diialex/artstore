@extends('layout')
@section('title', 'Favoritos')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full mb-20">
    
    <div class="flex items-center gap-3 mb-8 border-b border-gray-200 pb-4">
        <a href="{{ route('users.show', auth()->user()->username) }}" class="text-gray-400 hover:text-dark transition-colors mr-2 hidden sm:block">
            <i class="bi bi-arrow-left text-xl"></i>
        </a>
        <i class="bi bi-heart-fill text-primary text-2xl animate-pulse"></i>
        <h1 class="text-3xl font-black text-dark uppercase tracking-widest">@lang('messages.myfavs')</h1>
    </div>
    
    @if (empty($products) || count($products) == 0)
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm mt-4">
            <i class="bi bi-heart text-7xl text-gray-200 mb-6 block"></i>
            <h3 class="text-2xl font-bold text-dark mb-2">@lang('messages.no_favorites')</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto text-center font-medium">Explora nuestra colección y guarda los artículos que más te gusten.</p>
            <a href="{{ route('home') }}" class="px-8 py-4 bg-dark text-white font-bold rounded-full uppercase tracking-widest text-sm hover:bg-opacity-90 transition-all active:scale-95 shadow-md">
                @lang('messages.store_go')
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="w-full">
                    @include('partials.product-card', ['product' => $product, 'isFavoritesPage' => true])
                </div>
            @endforeach
        </div>
    @endif
    
</div>
@endsection