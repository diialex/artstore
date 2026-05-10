@extends('layout')

@section('title', $product->exists ? 'Editar Producto' : 'Nuevo Producto')

@section('content')
    <div class="row justify-content-center mt-4 mb-5">
        <div class="col-md-5">
            <h2 class="mb-4 text-uppercase tracking-wide fw-bold">
                {{ $product->exists ? 'Editar Producto' : 'Crear Producto' }}
            </h2>

            <form method="POST" enctype="multipart/form-data" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}" class="p-4 bg-white border rounded-4 shadow-sm">
                @csrf
                @if($product->exists) @method('PUT') 
                    @section('title', 'Editar Producto')
                @endif
                @section('title', 'Crear Producto')

                <div class="form-group mb-3">
                    <label class="fw-bold small text-uppercase">@lang('messages.title')</label>
                    <input name="title" class="form-control bg-light border-0" value="{{ old('title', $product->title) }}">
                    @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold small text-uppercase">@lang('messages.description')</label>
                    <textarea name="description" class="form-control bg-light border-0">{{ old('description', $product->description) }}</textarea>
                    @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold small text-uppercase">@lang('messages.image_product')</label>
                    <input type="file" name="image_url" class="form-control bg-light border-0" accept="image/*">
                    @error('image_url') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    
                    @if($product->exists && $product->image_url)
                        <div class="mt-3 p-2 border rounded text-center">
                            <small class="text-muted d-block mb-2">@lang('messages.act_image')</small>
                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->title }}" class="img-fluid rounded" style="max-height: 120px;">
                        </div>
                    @endif
                </div>
                
                <div class="form-group mb-3">
                    <label class="fw-bold small text-uppercase">@lang('messages.price')</label>
                    <input type="number" step="0.01" name="price" class="form-control bg-light border-0" value="{{ old('price', $product->price) }}">
                    @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="fw-bold small text-uppercase">@lang('messages.stock')</label>
                    <input type="text" class="form-control border-0 bg-secondary bg-opacity-10 text-muted" value="{{ $product->exists ? $product->total_stock : 0 }} uds" readonly>
                    <div class="form-text text-muted small">
                        @lang('messages.calculated_size')
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="fw-bold small text-uppercase mb-2">@lang('messages.categories')</label>
                    <div class="row g-2 bg-light p-3 rounded-3 border-0">
                        @foreach($categories as $category)
                            <div class="col-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input border-dark shadow-none" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat_{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', $product->exists ? $product->categories->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                                    <label class="form-check-label user-select-none cursor-pointer" for="cat_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('categories') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group mb-4">
                    <label class="fw-bold small text-uppercase m-0 mb-2">Tallas y Stock</label>
                    <div class="form-text text-muted mb-3">
                        @lang('messages.fill_sizes')
                    </div>
                    
                    <div id="sizes-container">
                        @php $index = 0; @endphp

                        @if($product->exists)
                            @foreach($product->sizes as $size)
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <input type="text" name="sizes[{{ $index }}][name]" class="form-control form-control-sm border-dark" value="{{ $size->size }}" placeholder="Ej: L, Única">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="sizes[{{ $index }}][stock]" class="form-control form-control-sm border-dark" value="{{ $size->stock }}" placeholder="Stock" min="0">
                                    </div>
                                </div>
                                @php $index++; @endphp
                            @endforeach
                        @endif

                        @for($i = 0; $i < 3; $i++)
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <input type="text" name="sizes[{{ $index }}][name]" class="form-control form-control-sm bg-light border-0" value="" placeholder="Nueva talla (opc)">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="sizes[{{ $index }}][stock]" class="form-control form-control-sm bg-light border-0" value="0" placeholder="Stock" min="0">
                                </div>
                            </div>
                            @php $index++; @endphp
                        @endfor
                    </div>
                </div>

                <button class="btn btn-dark w-100 py-3 rounded-pill fw-bold text-uppercase tracking-wide mt-3">
                    {{ $product->exists ? 'Actualizar Producto' : 'Crear Producto' }}
                </button>
            </form>
        </div>
    </div>
@endsection