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

                <form action="{{ route('orders.addProduct', $product) }}" method="POST" class="mt-5">
                    @csrf
                    <div class="mb-4">
                        <label class="fw-bold text-uppercase small tracking-wide d-block mb-3">Selecciona tu talla</label>
                        
                        <div class="row g-2">
                            @if($product->sizes && $product->sizes->count() > 0)
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @foreach($product->sizes as $size)
                                        {{-- Input oculto que maneja la selección --}}
                                        <input type="radio" class="btn-check" name="size_id" 
                                            id="size_{{ $size->id }}" value="{{ $size->id }}" 
                                            autocomplete="off" {{ $size->stock <= 0 ? 'disabled' : '' }} required>
                                        
                                        {{-- Label estilizado como botón --}}
                                        <label class="btn btn-outline-primary btn-hover-scale d-flex flex-column align-items-center justify-content-center p-2" 
                                            for="size_{{ $size->id }}" 
                                            style="min-width: 70px; border-width: 2px; border-radius: 8px;">
                                            
                                            <span class="fw-bold">{{ $size->size }}</span>
                                            
                                            <small class="text-uppercase" style="font-size: 0.65rem; opacity: 0.8;">
                                                {{ $size->stock }} ud.
                                            </small>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="col-12">
                                    <span class="badge bg-light text-danger p-2 w-100 text-start">
                                        <i class="bi bi-exclamation-triangle me-2"></i>No hay tallas disponibles para este producto
                                    </span>
                                </div>
                            @endif

                            {{-- Sección de Categorías --}}
                            <div class="mt-2 border-top pt-3">
                                @foreach($product->categories as $category)
                                    <span class="text-muted text-uppercase small tracking-widest me-3" style="font-size: 0.7rem;">
                                        <i class="bi bi-tag-fill me-1"></i>{{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 pt-3">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-dark btn-lg py-3 rounded-pill fw-bold text-uppercase tracking-wide">
                                Inicia sesión para comprar
                            </a>
                        @else
                            <button type="submit" class="btn btn-dark btn-lg py-3 rounded-pill fw-bold text-uppercase tracking-wide transition-transform hover-scale">
                                <i class="bi bi-bag-plus me-2"></i> Añadir a la bolsa
                            </button>
                        @endguest
                    </div>
                </form>

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