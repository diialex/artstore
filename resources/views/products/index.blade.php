@extends('adminLayout')
@section('title', 'Productos')
@section('content')
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <h2 class="text-3xl font-black text-dark tracking-tight">@lang('messages.product_management')</h2>
            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-success bg-opacity-20 text-green-800 border border-green-300 font-bold rounded-xl hover:bg-success hover:text-dark transition-colors shadow-sm">
                <i class="bi bi-plus-lg"></i>@lang('messages.create_new')
            </a>
        </div>

        @if(session('success'))
            <div class="bg-success bg-opacity-20 text-green-800 p-4 rounded-xl text-sm font-bold mb-8 flex items-center justify-between border border-green-200 shadow-sm js-alert">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle-fill text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.closest('.js-alert').remove()" class="text-green-800 hover:text-green-900 transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 mb-8 shadow-sm">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-4">
                <label for="category" class="font-bold text-gray-700 text-sm uppercase tracking-widest whitespace-nowrap">@lang('messages.category_filter') :</label>
                
                <div class="relative w-full sm:w-auto flex-grow max-w-md">
                    <select name="category" id="category" class="w-full appearance-none bg-white border border-gray-300 text-gray-700 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all pr-10 cursor-pointer" onchange="this.form.submit()">
                        <option value="">@lang('messages.all_categories')</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <i class="bi bi-chevron-down text-xs"></i>
                    </div>
                </div>

                @if(request('category'))
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-gray-600 font-bold rounded-xl hover:bg-gray-100 hover:text-dark transition-colors text-sm whitespace-nowrap">
                        <i class="bi bi-x-circle"></i> @lang('messages.clean_filters')
                    </a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>

        @if(method_exists($products, 'links'))
            <div class="mt-12 flex justify-center w-full">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection