@extends('layout')
@section('title', 'Carrito')
@section('content')

@section('content')
<div class="container-fluid px-4 px-lg-5 mt-4 mb-5">
    
    <h1 class="display-5 fw-bolder mb-5 text-uppercase tracking-wide">Tu Cesta</h1>

    @if(!$order || $order->items->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-bag-x display-1 text-muted mb-4"></i>
            <h3 class="fw-light">Tu cesta está vacía.</h3>
            <p class="text-muted mb-4">Descubre las últimas tendencias y añade tus favoritos.</p>
            <a href="{{ route('home') }}" class="btn btn-dark px-5 py-3 rounded-pill fw-bold text-uppercase tracking-wide">
                Descubrir productos
            </a>
        </div>
    @else
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-end border-bottom pb-3 mb-4">
                    <span class="text-muted text-uppercase small fw-bold">Artículo</span>
                    <span class="text-muted text-uppercase small fw-bold">Subtotal</span>
                </div>

                @foreach($order->items as $item)
                    <div class="row align-items-center mb-4 pb-4 border-bottom position-relative producto-cesta">
                        <div class="col-4 col-md-3">
                            @if($item->product->image_url)
                                <img src="{{ asset('storage/' . $item->product->image_url) }}" 
                                     class="img-fluid rounded-4 object-fit-cover shadow-sm" 
                                     alt="{{ $item->product->title }}" style="aspect-ratio: 3/4;">
                            @else
                                <div class="bg-light rounded-4 d-flex align-items-center justify-content-center h-100" style="aspect-ratio: 3/4;">
                                    <i class="bi bi-camera text-muted fs-3"></i>
                                </div>
                            @endif
                        </div>

                        <div class="col-8 col-md-6 d-flex flex-column h-100 justify-content-center">
                            <h4 class="fw-bold fs-5 mb-1">{{ $item->product->title }}</h4>
                            <p class="text-muted mb-3">{{ number_format($item->price, 2) }} € <span class="mx-2">|</span> Cantidad: <b>{{ $item->quantity }}</b></p>
                            <form action="{{ route('orderitems.delete', $item->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres quitar esto de la cesta?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none small text-uppercase fw-bold tracking-wide">
                                    <i class="bi bi-trash3 me-1"></i> Eliminar
                                </button>
                            </form>
                        </div>
                        <div class="col-12 col-md-3 text-md-end mt-3 mt-md-0">
                            <span class="fs-4 fw-bold">{{ number_format($item->price * $item->quantity, 2) }} €</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <div class="bg-light rounded-4 p-4 p-lg-5 sticky-top shadow-sm border border-secondary border-opacity-10" style="top: 120px; z-index: 1;">
                    <h3 class="fs-4 fw-bold mb-4 text-uppercase border-bottom pb-3">Resumen</h3>
                    
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Subtotal de artículos</span>
                        <span>{{ number_format($order->total_amount, 2) }} €</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 text-muted border-bottom pb-4">
                        <span>Gastos de envío</span>
                        <span class="text-success">Gratis</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5 fw-bolder text-uppercase">Total</span>
                        <span class="fs-3 fw-bolder">{{ number_format($order->total_amount, 2) }} €</span>
                    </div>

                    <p class="small text-muted mb-4">El total incluye IVA.</p>
                    
                    <form method="post" action="{{ route('payments.pay', $order) }}">
                        @csrf
                        
                        {{-- CSS Corregido --}}
                        <style>
                            .seccion-nueva-dir, .seccion-guardada-dir { display: none; margin-top: 15px; }
            
                            #modo_guardada:checked ~ .seccion-guardada-dir { display: block; }
                            #modo_nueva:checked ~ .seccion-nueva-dir { display: block; }
                        </style>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase tracking-wide mb-3 d-block">Dirección de Envío:</label>
                            
                            @if(auth()->user()->addresses && auth()->user()->addresses->count() > 0)
                                <input class="form-check-input border-dark shadow-none me-1" type="radio" name="address_mode" id="modo_guardada" value="saved" checked>
                                <label class="form-check-label fw-bold me-4 cursor-pointer" for="modo_guardada">
                                    Direcciones guardadas
                                </label>
                                
                                <input class="form-check-input border-dark shadow-none me-1" type="radio" name="address_mode" id="modo_nueva" value="new" {{ old('address_mode') == 'new' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold cursor-pointer" for="modo_nueva">
                                    Añadir nueva
                                </label>

                                <div class="seccion-guardada-dir bg-white p-3 border rounded-3">
                                    <select name="address_id" class="form-select border-dark bg-transparent shadow-none">
                                        @foreach ($order->user->addresses as $address)
                                            <option value="{{ $address->id }}">
                                                {{ $address->street }}, {{ $address->city }} ({{ $address->zip_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="address_mode" id="modo_nueva" value="new">
                                <div class="alert alert-secondary border-0 small py-2 mb-3">Aún no tienes direcciones. Introduce una:</div>
                            @endif

                            <div class="seccion-nueva-dir bg-white p-3 border rounded-3 {{ auth()->user()->addresses->count() == 0 ? 'd-block' : '' }}">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <input type="text" name="new_street" class="form-control border-dark bg-transparent shadow-none @error('new_street') is-invalid @enderror" placeholder="Calle y número" value="{{ old('new_street') }}">
                                        @error('new_street') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" name="new_city" class="form-control border-dark bg-transparent shadow-none @error('new_city') is-invalid @enderror" placeholder="Ciudad" value="{{ old('new_city') }}">
                                        @error('new_city') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="new_zip_code" class="form-control border-dark bg-transparent shadow-none @error('new_zip_code') is-invalid @enderror" placeholder="C.P." value="{{ old('new_zip_code') }}">
                                        @error('new_zip_code') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-3 rounded-pill fw-bold fs-5 text-uppercase tracking-wide btn-hover-scale mt-2">
                            Tramitar Pedido <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </form>
                    
                    <div class="text-center mt-4 text-muted small">
                        <i class="bi bi-shield-check me-1"></i> Pago 100% seguro
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
