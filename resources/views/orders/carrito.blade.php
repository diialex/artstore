@extends('layout')
@section('title', 'Carrito')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20 w-full">
    
    <h1 class="text-3xl md:text-4xl font-black mb-10 text-dark tracking-widest uppercase">@lang('messages.yourcart')</h1>

    @if(!$order || $order->items->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
            <i class="bi bi-bag-x text-7xl text-gray-300 mb-6"></i>
            <h3 class="text-2xl font-light text-dark mb-2">@lang('messages.empty_cart')</h3>
            <p class="text-gray-500 mb-8">@lang('messages.discover_products')</p>
            <a href="{{ route('home') }}" class="px-8 py-4 bg-dark text-white font-bold rounded-full uppercase tracking-widest text-sm hover:bg-opacity-90 transition-all shadow-md hover:shadow-lg active:scale-95">
                @lang('messages.discover')
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">
            
            <div class="lg:col-span-8">
                <div class="flex justify-between items-end border-b border-gray-200 pb-4 mb-6">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">@lang('messages.article')</span>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest hidden sm:block">@lang('messages.subtot')</span>
                </div>

                <div class="flex flex-col gap-6">
                    @foreach($order->items as $item)
                        <div class="flex flex-col sm:flex-row gap-6 py-4 border-b border-gray-100 group transition-colors hover:bg-gray-50/50 -mx-4 px-4 rounded-2xl">
                            
                            <div class="w-24 sm:w-32 shrink-0">
                                @if($item->product->image_url)
                                    <img src="{{ asset($item->product->image_url) }}" 
                                         class="w-full aspect-[3/4] object-cover rounded-xl shadow-sm" 
                                         alt="{{ $item->product->title }}">
                                @else
                                    <div class="w-full aspect-[3/4] bg-gray-100 rounded-xl flex items-center justify-center">
                                        <i class="bi bi-camera text-gray-400 text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 flex flex-col justify-center">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="font-bold text-lg text-dark">{{ $item->product->title }}</h4>
                                    <span class="text-lg font-black text-dark sm:hidden">{{ number_format($item->price * $item->quantity, 2) }} €</span>
                                </div>
                                

                               <h5 class="text-sm font-medium text-gray-500 mb-4">Talla: <span class="text-dark font-bold">{{ $item->size->size ?? 'Única' }}</span></h5>
                                
                                <div class="flex items-center gap-6 mb-4">
                                    <span class="text-gray-500 font-medium">{{ number_format($item->price, 2) }} €</span>
                                    
                                    <div class="flex items-center border border-gray-200 rounded-full px-1 py-1 bg-white">
                                        @auth
                                        <form action="{{ route('cart.decrease', $item) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-dark hover:bg-gray-100 rounded-full transition-colors focus:outline-none">
                                                <i class="bi bi-dash-lg text-xs"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('cart.guest.decrease') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-dark hover:bg-gray-100 rounded-full transition-colors focus:outline-none">
                                                <i class="bi bi-dash-lg text-xs"></i>
                                            </button>
                                        </form>
                                        @endauth
                                        
                                        <span class="w-8 text-center font-bold text-sm">{{ $item->quantity }}</span>
                                        
                                        @auth
                                        <form action="{{ route('cart.increase', $item) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-dark hover:bg-gray-100 rounded-full transition-colors focus:outline-none">
                                                <i class="bi bi-plus-lg text-xs"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('cart.guest.increase') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-dark hover:bg-gray-100 rounded-full transition-colors focus:outline-none">
                                                <i class="bi bi-plus-lg text-xs"></i>
                                            </button>
                                        </form>
                                        @endauth
                                    </div>
                                </div>

                                <form action="{{ route('orderitems.delete', $item->id) }}" method="POST" class="mt-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold uppercase tracking-widest flex items-center gap-1 transition-colors focus:outline-none">
                                        <i class="bi bi-trash3 text-sm"></i> @lang('messages.eliminate')
                                    </button>
                                </form>
                            </div>

                            <div class="hidden sm:flex flex-col justify-center items-end shrink-0 pl-4">
                                <span class="text-xl font-black text-dark">{{ number_format($item->price * $item->quantity, 2) }} €</span>
                            </div>
                            @auth
                            <form action="{{ route('orderitems.delete', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none small text-uppercase fw-bold tracking-wide">
                                    <i class="bi bi-trash3 me-1"></i> @lang('messages.eliminate')
                                </button>
                            </form>
                            @else
                            <form action="{{ route('cart.guest.decrease') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="hidden" name="remove_all" value="1">
                                <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none small text-uppercase fw-bold tracking-wide">
                                    <i class="bi bi-trash3 me-1"></i> @lang('messages.eliminate')
                                </button>
                            </form>
                            @endauth
                        </div>
                        <div class="col-12 col-md-3 text-md-end mt-3 mt-md-0">
                            <span class="fs-4 fw-bold">{{ number_format($item->price * $item->quantity, 2) }} €</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-4 relative">
                <div class="bg-gray-50 rounded-3xl p-6 sm:p-8 sticky top-28 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-black mb-6 text-uppercase border-b border-gray-200 pb-4 text-dark tracking-wide">@lang('messages.summary')</h3>
                    
                    <div class="flex justify-between mb-4 text-sm font-medium text-gray-600">
                        <span>@lang('messages.subArticle_total')</span>
                        <span>{{ number_format($order->total_amount, 2) }} €</span>
                    </div>
                    
                    <div class="flex justify-between mb-6 text-sm font-medium text-gray-600 border-b border-gray-200 pb-6">
                        <span>@lang('messages.send_waste')</span>
                        <span class="text-success font-bold uppercase tracking-wide">@lang('messages.free')</span>
                    </div>
                    
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-lg font-black uppercase tracking-widest text-dark">@lang('messages.total')</span>
                        <span class="text-3xl font-black text-dark">{{ number_format($order->total_amount, 2) }} €</span>
                    </div>

                    <p class="text-xs text-gray-400 mb-8 font-medium">@lang('messages.ivaincluded')</p>
                    
                    @auth
                    <form method="post" action="{{ route('payments.pay', $order) }}" class="flex flex-col gap-6">
                        @csrf
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">@lang('messages.sendaddress')</label>
                            
                            @if(auth()->user()->addresses && auth()->user()->addresses->count() > 0)
                                <div class="flex flex-col sm:flex-row gap-4 mb-4">
                                    <label class="flex items-center gap-2 cursor-pointer group">
                                        <input type="radio" name="address_mode" id="modo_guardada" value="saved" checked class="w-4 h-4 text-[#212529] focus:ring-[#212529] border-gray-300 js-address-toggle">
                                        <span class="text-sm font-bold text-gray-700 group-hover:text-dark">@lang('messages.savedaddresses')</span>
                                    </label>
                                    
                                    <label class="flex items-center gap-2 cursor-pointer group">
                                        <input type="radio" name="address_mode" id="modo_nueva" value="new" {{ old('address_mode') == 'new' ? 'checked' : '' }} class="w-4 h-4 text-[#212529] focus:ring-[#212529] border-gray-300 js-address-toggle">
                                        <span class="text-sm font-bold text-gray-700 group-hover:text-dark">@lang('messages.newaddress')</span>
                                    </label>
                                </div>
                            @endif

                                <div id="seccion-guardada-dir" class="bg-white p-4 border border-gray-200 rounded-xl transition-all">
                                    <div class="relative">
                                        <select name="address_id" class="w-full appearance-none bg-transparent text-gray-700 text-sm font-medium focus:outline-none cursor-pointer pr-8">
                                            @foreach ($order->user->addresses as $address)
                                                <option value="{{ $address->id }}">
                                                    {{ $address->street }}, {{ $address->city }} ({{ $address->zip_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center text-gray-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="address_mode" id="modo_nueva" value="new">
                                <div class="bg-blue-50 text-blue-800 border border-blue-100 p-3 rounded-lg text-xs font-bold mb-4 flex items-center gap-2">
                                    <i class="bi bi-info-circle"></i> @lang('messages.noaddressesyet')
                                </div>
                            @endif

                            <div id="seccion-nueva-dir" class="bg-white p-4 border border-gray-200 rounded-xl transition-all mt-4 {{ (!auth()->user()->addresses || auth()->user()->addresses->count() == 0) ? 'block' : 'hidden' }}">
                                <div class="flex flex-col gap-3">
                                    <div>
                                        <input type="text" name="new_street" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400" placeholder="Calle y número" value="{{ old('new_street') }}">
                                        @error('new_street') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex-1">
                                            <input type="text" name="new_city" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400" placeholder="Ciudad" value="{{ old('new_city') }}">
                                            @error('new_city') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="w-1/3">
                                            <input type="text" name="new_zip_code" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400" placeholder="C.P." value="{{ old('new_zip_code') }}">
                                            @error('new_zip_code') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#212529] text-white py-4 rounded-full font-bold text-lg uppercase tracking-widest hover:bg-opacity-90 hover:shadow-lg transition-all active:scale-95 flex items-center justify-center gap-3 mt-2">
                            @lang('messages.tramit_pedido') <i class="bi bi-arrow-right"></i>
                        </button>
                    </form>
                    @else
                    <button type="button" data-bs-toggle="offcanvas" data-bs-target="#iniciarSesion" class="btn btn-dark w-100 py-3 rounded-pill fw-bold fs-5 text-uppercase tracking-wide btn-hover-scale mt-2">
                        Inicia sesión para finalizar el pedido <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                    @endauth
                    
                    <div class="text-center mt-6 text-gray-400 text-xs font-bold uppercase tracking-widest flex items-center justify-center gap-1.5">
                        <i class="bi bi-shield-lock-fill text-sm"></i> @lang('messages.savepay')
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.js-address-toggle');
        const secGuardada = document.getElementById('seccion-guardada-dir');
        const secNueva = document.getElementById('seccion-nueva-dir');

        if(toggles.length > 0 && secGuardada && secNueva) {
            function updateAddressView() {
                const isNew = document.getElementById('modo_nueva').checked;
                if(isNew) {
                    secGuardada.classList.add('hidden');
                    secNueva.classList.remove('hidden');
                } else {
                    secGuardada.classList.remove('hidden');
                    secNueva.classList.add('hidden');
                }
            }

            toggles.forEach(toggle => {
                toggle.addEventListener('change', updateAddressView);
            });

            // Forzar vista inicial si hubo errores de validación
            updateAddressView();
        }
    });
</script>
@endsection