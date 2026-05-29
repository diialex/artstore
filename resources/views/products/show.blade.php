@extends('layout')

@section('title', $product->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mb-12">
    <div class="flex flex-col lg:flex-row gap-12">
        
        <div class="w-full lg:w-3/5">
            <div class="sticky top-24">
                @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" 
                         class="w-full h-auto max-h-[80vh] object-cover rounded-2xl shadow-sm border border-gray-100" 
                         alt="{{ $product->title }}">
                @else
                    <div class="w-full h-[600px] bg-gray-50 flex items-center justify-center rounded-2xl shadow-sm border border-gray-100">
                        <span class="text-gray-400 text-2xl flex items-center gap-3">
                            <i class="bi bi-camera"></i> @lang('messages.no_image_available')
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="w-full lg:w-2/5 lg:pl-8">
            <h1 class="text-4xl font-black uppercase tracking-tight text-gray-900 mb-4 leading-tight">
                {{ $product->title }}
            </h1>
            <p class="text-3xl font-light text-gray-900 mb-8">
                {{ number_format($product->price, 2) }} €
            </p>

            <hr class="border-gray-200 mb-8">

            <div class="mb-10">
                <p class="text-sm font-bold uppercase tracking-widest text-gray-900 mb-3">@lang('message.description')</p>
                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
            </div>

            @auth
                @if($product->stock > 0 || $product->sizes->sum('stock') > 0)
                <form action="{{ route('orders.addProduct', $product) }}" method="POST" class="mt-8 js-add-cart-form">
                    @csrf
                    
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <label class="text-sm font-bold uppercase tracking-widest text-gray-900">@lang('message.select_size')</label>
                            <a href="#" class="text-sm text-gray-500 underline hover:text-dark">Guía de tallas</a>
                        </div>
                        
                        <div class="grid grid-cols-4 gap-3">
                            @forelse($product->sizes as $size)
                                @if($size->stock > 0)
                                    <div>
                                        <input type="radio" name="size_id" id="size_{{ $size->id }}" value="{{ $size->id }}" class="peer sr-only js-size-radio">
                                        
                                        <label for="size_{{ $size->id }}" 
                                            class="flex flex-col items-center justify-center w-full py-3.5 bg-gray-100 border-2 border-transparent text-gray-600 rounded-xl cursor-pointer hover:border-gray-300 transition-all peer-checked:bg-[#212529] peer-checked:border-[#212529] peer-checked:text-white font-sans shadow-sm text-center">
                                            
                                            <span class="text-base font-bold uppercase leading-none">{{ $size->size }}</span>
                                            <span class="text-[0.65rem] font-bold opacity-70 mt-1.5 leading-none">{{ $size->stock }} ud.</span>
                                        </label>
                                    </div>
                                @else
                                    <div>
                                        <div class="flex flex-col items-center justify-center w-full py-3.5 bg-gray-50 border-2 border-transparent rounded-xl opacity-50 cursor-not-allowed font-sans text-gray-400 text-center">
                                            <span class="text-base font-bold line-through leading-none">{{ $size->size }}</span>
                                            <span class="text-[0.65rem] mt-1.5 leading-none">@lang('message.out_of_stock')</span>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="col-span-4">
                                    <p class="text-gray-500 italic text-sm py-2">@lang('message.only_size')</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 flex flex-wrap gap-2">
                            @foreach($product->categories as $category)
                                <span class="bg-gray-100 text-gray-600 text-[0.7rem] font-bold uppercase tracking-widest px-3 py-1 rounded-full">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="js-size-warning hidden text-red-500 text-sm font-bold uppercase tracking-wider text-center mb-4">
                        <i class="bi bi-exclamation-triangle mr-1"></i> @lang('message.please_select_size')
                    </div>

                    <button type="submit" class="w-full bg-[#212529] text-white text-lg font-bold uppercase tracking-widest py-4 rounded-full hover:bg-opacity-90 hover:shadow-lg transition-all transform active:scale-95 flex justify-center items-center gap-3">
                        <i class="bi bi-bag-plus"></i> @lang('message.add_bag')
                    </button>
                </form>
                @else
                <div class="mb-8">
                    <p class="text-red-500 font-bold mb-4">@lang('message.product_out_of_stock')</p>
                    <button disabled class="w-full bg-gray-200 text-gray-400 text-lg font-bold uppercase tracking-widest py-4 rounded-full cursor-not-allowed">
                        @lang('message.out_of_stock')
                    </button>
                </div>
                @endif
            @endauth

            @guest
                <div class="mt-8">
                    <button type="button" onclick="toggleMenu('iniciarSesion')" class="w-full inline-flex justify-center items-center px-4 py-2.5 border-2 border-[#212529] text-[#212529] font-bold rounded-full hover:bg-[#212529] hover:text-white transition-colors">
                        <i class="bi bi-box-arrow-in-right mr-2"></i>@lang('messages.login_to_buy')
                    </button>
                </div>
            @endguest

            <div class="mt-12 pt-8 border-t border-gray-200 space-y-4">
                <div class="flex items-center text-gray-600">
                    <i class="bi bi-truck text-2xl w-10"></i>
                    <span class="text-xs font-bold uppercase tracking-wide">@lang('messages.send_free_waste')</span>
                </div>
                <div class="flex items-center text-gray-600">
                    <i class="bi bi-arrow-left-right text-2xl w-10"></i>
                    <span class="text-xs font-bold uppercase tracking-wide">@lang('messages.free_giveback')</span>
                </div>
            </div>

            @if(auth()->check() && auth()->user()->roles->contains('id', 1))
                <div class="mt-12 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex gap-3">
                    <a href="{{ route('products.edit', $product) }}" class="flex-1 flex justify-center items-center bg-white text-amber-700 border border-amber-200 py-2 rounded-full font-bold text-sm hover:bg-amber-100 transition-colors">
                        @lang('messages.edit')
                    </a>
                    <form action="{{ route('products.delete', $product) }}" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button class="w-full flex justify-center items-center bg-red-50 text-red-600 border border-red-200 py-2 rounded-full font-bold text-sm hover:bg-red-600 hover:text-white transition-colors">
                            @lang('messages.eliminate')
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection