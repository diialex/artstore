@extends('layout')

@section('title', 'Favoritos')

@section('content')
<div class="min-h-screen bg-body-bg py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="flex items-center gap-3 mb-8 border-b border-gray-200 pb-4">
            <i class="bi bi-heart-fill text-primary text-3xl animate-pulse"></i>
            <h1 class="text-3xl font-bold text-dark">@lang('messages.myfavs')</h1>
        </div>
        
        @if (empty($products) || count($products) == 0)
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">
                <i class="bi bi-heart text-gray-300 text-6xl mb-4 block"></i>
                <h3 class="text-xl font-medium text-gray-900 mb-2">@lang('messages.no_favorites')</h3>
                <p class="text-gray-500 mb-6">Explora nuestra colección y guarda los artículos que más te gusten.</p>
                <a href="{{ route('home') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-full font-medium hover:bg-opacity-90 transition-all hover:-translate-y-1 hover:shadow-lg">
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
</div>
@endsection