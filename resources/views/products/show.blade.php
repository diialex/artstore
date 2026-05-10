@extends('layout')

@section('title', $product->title)

@section('content')
<div class="container mt-5 mb-5">
    <div class="row g-5">
        
        <div class="col-md-7">
            <div class="position-sticky" style="top: 100px;">
                @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" 
                         class="img-fluid rounded-4 shadow-sm w-100 object-fit-cover" 
                         alt="{{ $product->title }}" 
                         style="max-height: 80vh;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded-4 shadow-sm w-100" 
                         style="height: 600px;">
                        <span class="text-muted fs-4">📸 Sin imagen disponible</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-5">
            <div class="ps-md-4">
                

                <h1 class="display-5 fw-bold text-uppercase tracking-tight mb-3">{{ $product->title }}</h1>
                <p class="fs-3 fw-light mb-4">{{ number_format($product->price, 2) }} €</p>

                <hr class="border-dark opacity-100 mb-4">

                <div class="mb-4">
                    <p class="fw-bold text-uppercase small tracking-wide mb-2">Descripción</p>
                    <p class="text-muted lh-lg">{{ $product->description }}</p>
                </div>
                @auth
                    @if($product->stock > 0)
                    <form action="{{ route('orders.addProduct', $product) }}" method="POST" class="mt-5">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="fw-bold text-uppercase small tracking-wide d-block mb-3">Selecciona tu talla</label>
                            <style>
                                .btn-check:checked + .btn-size-option {
                                    background-color: var(--bs-primary) !important;
                                    border-color: var(--bs-primary) !important;
                                    color: white !important;
                                }
                            </style>
                            <div class="row g-2">
                                @forelse($product->sizes as $size)
                                    @if($size->stock > 0)
                                        <div class="col-3">
                                            <input type="radio" class="btn-check" name="size_id" id="size_{{ $size->id }}" value="{{ $size->id }}" required>
                                            <label class="btn btn-light border w-100 py-1 px-1 rounded-3 fw-bold text-uppercase transition-transform hover-scale btn-size-option" for="size_{{ $size->id }}">
                                                <span class="d-block" style="font-size: 0.9rem;">{{ $size->size }}</span>
                                                <small class="fw-normal text-nowrap" style="font-size: 0.65rem;">{{ $size->stock }} ud.</small>
                                            </label>
                                        </div>
                                    @else
                                        <div class="col-3">
                                            <button type="button" class="btn btn-light border w-100 py-1 px-1 rounded-3 text-muted disabled text-decoration-line-through">
                                                <span class="d-block" style="font-size: 0.9rem;">{{ $size->size }}</span>
                                                <small class="fw-normal text-nowrap" style="font-size: 0.65rem;">Agotado</small>
                                            </button>
                                        </div>
                                    @endif
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted italic small">Talla única / Stock general</p>
                                    </div>
                                @endforelse

                                <div class="mb-2">
                                    @foreach($product->categories as $category)
                                        <span class="text-muted text-uppercase small tracking-widest me-2">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark btn-lg py-3 rounded-pill fw-bold text-uppercase tracking-wide transition-transform hover-scale">
                            <i class="bi bi-bag-plus me-2"></i> Añadir a la bolsa
                        </button>
                    </form>
                    @else
                    <div class="mb-4">
                        <span>No hay productos disponibles</span>
                        <div class="d-grid gap-2 pt-3">
                            <a href="#" 
                                class="btn btn-dark btn-lg py-3 rounded-pill fw-bold text-uppercase tracking-wide disabled" 
                                tabindex="-1" 
                                role="button" 
                                aria-disabled="true">
                                    Añadir a la bolsa
                                </a>
                        </div>
                    </div>
                    @endif
                @endauth
                @guest
                    <div class="d-grid gap-2 pt-3">
                        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#iniciarSesion" class="btn btn-dark btn-lg py-3 rounded-pill fw-bold text-uppercase tracking-wide">
                            Inicia sesión para comprar
                        </a>
                    </div>
                @endguest

                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-truck fs-4 me-3"></i>
                        <span class="small text-uppercase">Envío gratuito en pedidos superiores a 50€</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-arrow-left-right fs-4 me-3"></i>
                        <span class="small text-uppercase">Devoluciones gratuitas en 30 días</span>
                    </div>
                </div>

                @if(auth()->check() && auth()->user()->role_id == 1)
                    <div class="mt-5 p-3 bg-light rounded-3 d-flex gap-2">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm flex-fill fw-bold rounded-pill">Editar</a>
                        <form action="{{ route('products.delete', $product) }}" method="POST" class="flex-fill">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm w-100 fw-bold rounded-pill">Eliminar</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection