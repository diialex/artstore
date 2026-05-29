@extends('adminLayout') 
@section('title', $product->exists ? __('message.edit_product') : __('message.create_product'))

@section('content')
<div class="w-full max-w-[1000px] mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    
    <div class="mb-8 border-b border-gray-200 pb-4 flex items-center gap-4">
        <a href="{{ route('products.index') }}" class="text-gray-400 hover:text-dark transition-colors">
            <i class="bi bi-arrow-left text-xl"></i>
        </a>
        <h2 class="text-3xl font-black text-dark tracking-tight uppercase">
            {{ $product->exists ? __('message.edit_product') : __('message.create_product') }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <form method="POST" enctype="multipart/form-data" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}" class="p-8 sm:p-10 space-y-8">
            @csrf
            @if($product->exists) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.title')</label>
                    <input type="text" name="title" value="{{ old('title', $product->title) }}" 
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    @error('title') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.price')</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" 
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    @error('price') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.stock') </label>
                    <input type="text" value="{{ $product->exists ? $product->total_stock : 0 }} uds" readonly 
                           class="w-full bg-gray-100 border border-transparent text-gray-500 rounded-xl px-4 py-3.5 text-sm font-medium cursor-not-allowed">
                    <p class="text-[0.65rem] text-gray-400 mt-2">@lang('messages.calculated_size')</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.description')</label>
                <textarea name="description" rows="4" 
                          class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-y">{{ old('description', $product->description) }}</textarea>
                @error('description') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
            </div>

            <div class="border-t border-gray-100 pt-8">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.image_product')</label>
                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <div class="flex-grow w-full">
                        <input type="file" name="image_url" accept="image/*" 
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-dark file:text-white hover:file:bg-opacity-90 file:cursor-pointer cursor-pointer">
                        @error('image_url') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    
                    @if($product->exists && $product->image_url)
                        <div class="shrink-0 w-32 h-32 rounded-2xl border border-gray-200 overflow-hidden relative group">
                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="Actual" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-white text-[0.65rem] font-bold uppercase tracking-widest">@lang('messages.actual')</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="border-t border-gray-100 pt-8">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">@lang('messages.categories')</label>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-5 bg-gray-50 rounded-2xl border border-gray-200">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                   {{ in_array($category->id, old('categories', $product->exists ? $product->categories->pluck('id')->toArray() : [])) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-gray-300 text-dark focus:ring-dark transition-all">
                            <span class="text-sm font-bold text-gray-700 group-hover:text-dark transition-colors">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('categories') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
            </div>
            
            <div class="border-t border-gray-100 pt-8">
                <div class="flex justify-between items-end mb-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest">@lang('messages.stock_size')</label>
                    <span class="text-[0.65rem] text-gray-400 font-bold uppercase">@lang('messages.fill_sizes')</span>
                </div>
                
                <div class="space-y-3 bg-gray-50 p-5 rounded-2xl border border-gray-200">
                    @php $index = 0; @endphp

                    @if($product->exists)
                        @foreach($product->sizes as $size)
                            <div class="flex gap-4">
                                <input type="text" name="sizes[{{ $index }}][name]" value="{{ $size->size }}" placeholder="Ej: L, Única"
                                       class="w-1/2 bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-bold focus:ring-2 focus:ring-primary outline-none">
                                <input type="number" name="sizes[{{ $index }}][stock]" value="{{ $size->stock }}" placeholder="Stock" min="0"
                                       class="w-1/2 bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-primary outline-none">
                            </div>
                            @php $index++; @endphp
                        @endforeach
                    @endif

                    @for($i = 0; $i < 3; $i++)
                        <div class="flex gap-4">
                            <input type="text" name="sizes[{{ $index }}][name]" value="" placeholder="Nueva talla (opc)"
                                   class="w-1/2 bg-transparent border border-dashed border-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium focus:bg-white focus:border-solid focus:ring-2 focus:ring-primary outline-none transition-all">
                            <input type="number" name="sizes[{{ $index }}][stock]" value="0" placeholder="Stock" min="0"
                                   class="w-1/2 bg-transparent border border-dashed border-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium focus:bg-white focus:border-solid focus:ring-2 focus:ring-primary outline-none transition-all">
                        </div>
                        @php $index++; @endphp
                    @endfor
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-dark text-white font-bold uppercase tracking-widest py-4 rounded-xl hover:bg-opacity-90 hover:shadow-lg transition-all active:scale-95 flex justify-center items-center gap-2">
                    <i class="bi bi-save"></i> {{ $product->exists ? __('message.update_product') : __('message.save_product') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection