@extends('layout')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Mis Favoritos</h1>
    
    @if ($products->isEmpty())
        <div class="alert alert-info text-center">
            <p class="mb-0">No tienes productos favoritos aún.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Ver productos</a>
        </div>
    @else
        <div class="row">
            @foreach ($products as $product)
                @include('products.card', ['isFavoritesPage' => true])
            @endforeach
        </div>
    @endif
</div>
@endsection
