@extends('adminLayout')
@section('title', 'Productos')

@section('content')
<div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-black text-dark tracking-tight uppercase">@lang('messages.products')</h2>
            <p class="text-sm text-gray-500 mt-1 font-medium">Gestión de inventario y catálogo</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-dark text-white font-bold rounded-full hover:bg-opacity-90 transition-all active:scale-95 shadow-sm">
                <i class="bi bi-plus-lg text-lg"></i> Añadir Producto
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-dark text-white p-4 rounded-xl text-sm font-bold mb-8 flex items-center justify-between shadow-lg js-alert">
            <div class="flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-success text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.closest('.js-alert').remove()" class="text-gray-400 hover:text-white transition-colors focus:outline-none">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Imagen</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Producto</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Precio</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Stock / Tallas</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            
                            <td class="px-6 py-4 align-middle w-24">
                                <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
                                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 align-middle">
                                <span class="font-black text-dark text-lg">{{ $product->title }}</span>
                                <p class="text-xs text-gray-500 mt-1 max-w-xs truncate">{{ $product->description }}</p>
                            </td>
                            
                            <td class="px-6 py-4 align-middle">
                                <span class="font-bold text-primary bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/20">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 align-middle">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($product->sizes as $size)
                                        <span class="inline-flex items-center px-2 py-1 rounded bg-gray-100 text-gray-600 text-[0.65rem] font-bold">
                                            {{ $size->size }}: {{ $size->stock }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic">Sin tallas</span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="px-6 py-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                    
                                    <a href="{{ route('products.edit', $product->id) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-colors" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <form action="{{ route('products.delete', $product->id) }}" method="POST" class="m-0" onsubmit="return confirm('¿Estás seguro de borrar el producto {{ $product->title }}?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors" title="Borrar">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="bi bi-box-seam text-5xl text-gray-200 mb-3"></i>
                                    <p class="text-gray-500 font-medium">No hay productos en el inventario.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection