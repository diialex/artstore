@extends('layout')
@section('title', 'Favoritos')
@section('content')
<div class="container my-5">
    <h1 class="mb-4">Mis Favoritos</h1>
    
    @if ($products->isEmpty())
        <div class="alert alert-info text-center">
            <p class="mb-0">No tienes productos favoritos aún.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Ver productos</a>
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
