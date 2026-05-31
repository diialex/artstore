@extends('adminLayout')
@section('title', 'Categorías')

@section('content')
<div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-black text-dark tracking-tight uppercase">@lang('messages.categories')</h2>
            <p class="text-sm text-gray-500 mt-1 font-medium">@lang('messages.manage_families')</p>
        </div>
        <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-dark text-white font-bold rounded-full hover:bg-opacity-90 transition-all active:scale-95 shadow-sm">
            <i class="bi bi-plus-lg text-lg"></i>@lang('messages.new_category')
        </a>
    </div>

    @if(session('success'))
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
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap w-1/4">@lang('messages.name')</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest w-2/4">@lang('messages.description')</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right w-1/4">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 align-middle">
                                <span class="font-black text-dark text-lg uppercase tracking-wider">{{ $category->name }}</span>
                            </td>
                            
                            <td class="px-6 py-4 align-middle">
                                <p class="text-sm font-medium text-gray-600">{{ Str::limit($category->description, 80) }}</p>
                            </td>

                            <td class="px-6 py-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('categories.edit', $category) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-colors" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <form action="{{ route('categories.delete', $category) }}" method="POST" class="m-0" onsubmit="return confirm('¿Estás seguro de borrar esta categoría?');">
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
                            <td colspan="3" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="bi bi-tags text-5xl text-gray-200 mb-3"></i>
                                    <p class="text-gray-500 font-medium">@lang('messages.no_categories')</p>
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