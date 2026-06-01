@extends('layout')
@section('title', 'Nueva Dirección')

@section('content')
<div class="flex justify-center items-center w-full py-12 px-4 sm:px-6 lg:px-8 mb-20">
    
    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all">
        
        <div class="px-8 pt-10 pb-6 text-center border-b border-gray-50">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-dark bg-opacity-5 mb-4 text-dark shadow-inner">
                <i class="bi bi-plus-lg text-3xl"></i>
            </div>
            <h2 class="text-2xl font-black text-dark tracking-tight uppercase">@lang('messages.newaddress')</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">@lang('messages.whereto_msg')</p>
        </div>

        <form action="{{ route('addresses.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            @if(!empty($userId))
                <input type="hidden" name="user_id" value="{{ $userId }}">
            @endif
            
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.address_info')</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="bi bi-signpost-split text-gray-400"></i>
                    </div>
                    <input type="text" name="street" value="{{ old('street') }}" autofocus
                           class="w-full pl-12 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                </div>
                @error('street') 
                    <span class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> 
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.city_local')</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-building text-gray-400"></i>
                        </div>
                        <input type="text" name="city" value="{{ old('city') }}"
                               class="w-full pl-12 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    </div>
                    @error('city') 
                        <span class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> 
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.postal_code')</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-mailbox text-gray-400"></i>
                        </div>
                        <input type="text" name="zip_code" value="{{ old('zip_code') }}"
                               class="w-full pl-12 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                    </div>
                    @error('zip_code') 
                        <span class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> 
                    @enderror
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="button" onclick="window.history.back();" class="w-full sm:w-auto px-6 py-4 text-gray-500 font-bold uppercase tracking-widest text-xs hover:text-dark hover:bg-gray-50 rounded-xl transition-colors">
                    @lang('messages.cancel')
                </button>
                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-primary text-white font-bold uppercase tracking-widest text-xs rounded-xl hover:bg-opacity-90 active:scale-95 transition-all shadow-sm flex items-center justify-center gap-2">
                    <i class="bi bi-save"></i> @lang('messages.save')
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
