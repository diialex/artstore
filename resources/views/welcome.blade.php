@extends('layout')
@section('title', 'Inicio')
@section('content')
    <main>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000"
            data-bs-pause="false">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('media/images/banner-example1.jpg') }}" class="d-block w-100 h-25 banner-img" alt="..." />
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('media/images/banner-example2.jpg') }}" class="d-block w-100 h-25 banner-img" alt="..." />
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('media/images/banner-example3.jpg') }}" class="d-block w-100 h-25 banner-img" alt="..." />
                </div>
            </div>
        </div>
        <div class="row g-4 m-0 px-2 px-md-5 mt-4">
            <div class="col-12">
                <p class="d-block d-md-none display-6 mb-0">Categorías</p>
                <p class="d-none d-md-block display-5 mb-0">Categorías</p>
                <hr class="border-secondary border-3">
            </div>

            @foreach($categories as $category)
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="text-decoration-none">
                        <div class="ratio ratio-1x1 position-relative overflow-hidden rounded-4 shadow-sm" style="cursor: pointer;">
                            
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="object-fit-cover w-100 h-100 transition-transform">
                            
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 transition-opacity hover-opacity-25"></div>
                            
                            <div class="position-absolute d-flex align-items-center justify-content-center text-white w-100 h-100">
                                <h3 class="fs-1 fw-bolder m-0 p-2 text-center text-uppercase tracking-wide">{{ $category->name }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            <div class="row">
                <div class="col-12">
                <p class="d-block d-md-none display-6 mb-0">Productos</p>
                <p class="d-none d-md-block display-5 mb-0">Productos</p>
                <hr class="border-secondary border-3">
            </div>
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h5 text-primary mb-0">{{ $product->price }} €</span>
                                <span class="badge bg-secondary">Stock: {{ $product->stock }}</span>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white d-flex justify-content-between">
                            
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning btn-sm">
                                Editar
                            </a>

                            <a href="{{ route('orders.addProduct', $product) }}" class="btn btn-outline-warning btn-sm">
                                Añadir al carrito
                            </a>

                            <form action="{{ route('products.delete', $product) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres aniquilar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    Borrar
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </main>

    <script src="lib/own/videoHover.js"></script>
    </body>
@endsection