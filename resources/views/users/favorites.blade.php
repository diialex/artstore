@extends('layout')
@section('title', 'Favoritos')
@section('content')
<div class="container my-5">
    <h1 class="mb-4">@lang('messages.myfavs')</h1>
    
    @if (empty($products))
        <div class="alert alert-info text-center">
            <p class="mb-0">@lang('messages.no_favorites')</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">@lang('messages.view_product')</a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    @include('partials.product-card', ['product' => $product, 'isFavoritesPage' => true])
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
