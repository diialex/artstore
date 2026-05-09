@extends('layout')
@section('title', 'Inicio')
@section('content')
    <main>
        @if(!request('category'))
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000" data-bs-pause="false">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/media/images/banner-example1.jpg') }}" class="d-block w-100 h-25 banner-img" alt="..." />
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('storage/media/images/banner-example2.jpg') }}" class="d-block w-100 h-25 banner-img" alt="..." />
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('storage/media/images/banner-example3.jpg') }}" class="d-block w-100 h-25 banner-img" alt="..." />
                    </div>
                </div>
            </div>

            <div class="row g-4 m-0 px-2 px-md-5 mt-4">
                <div class="col-12">
                    <p class="d-none d-md-block display-5 mb-0 text-uppercase tracking-wide">@lang('messages.categories')</p>
                    <hr class="border-dark border-2 opacity-100">
                </div>

                @foreach($categories as $category)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="{{ route('home', ['category' => $category->id]) }}" class="text-decoration-none">
                            <div class="ratio ratio-1x1 position-relative overflow-hidden rounded-4 shadow-sm tarjeta-categoria" style="cursor: pointer;">
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="object-fit-cover w-100 h-100 transition-transform">
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 transition-opacity hover-opacity-25"></div>
                                <div class="position-absolute d-flex align-items-center justify-content-center text-white w-100 h-100">
                                    <h3 class="fs-1 fw-bolder m-0 p-2 text-center text-uppercase tracking-wide">{{ $category->name }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="row g-4 m-0 px-2 px-md-5 {{ request('category') ? 'mt-2' : 'mt-5' }}">
            <div class="col-12">
                @php
                    $titulo = request('category') ? $categories->where('id', request('category'))->first()->name : trans('messages.all_products');
                @endphp
                <p class="d-block d-md-none display-6 mb-0 text-uppercase tracking-wide">{{ $titulo }}</p>
                <p class="d-none d-md-block display-5 mb-0 text-uppercase tracking-wide">{{ $titulo }}</p>
                <hr class="border-dark border-2 opacity-100">
            </div>

            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </main>

    <script src="lib/own/videoHover.js"></script>
@endsection