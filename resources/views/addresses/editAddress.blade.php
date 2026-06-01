@extends('layout')

@section('title', 'Editar Dirección')

@section('content')
<div class="min-h-screen bg-body-bg py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="bg-primary px-6 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="bi bi-pencil-square"></i> @lang('messages.edit_address')
                </h2>
                <p class="text-light text-sm mt-1">@lang('messages.update_ubi_data')</p>
            </div>

            <form action="{{ url('/updateAddress/' . $address->id) }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ $address->user_id }}">
                <input type="hidden" name="redirect_to" value="{{ $redirectTo ?? url('/addresses/user/' . $address->user->username) }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">@lang('messages.address_info')</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-signpost-split text-gray-400"></i>
                        </div>
                        <input type="text" name="street" value=" {{ old('street', $address->street) }}" autofocus
                            class="w-full pl-10 rounded-lg border-gray-300 border px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all hover:border-gray-400">
                    </div>
                    @error('street') 
                        <span class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </span> 
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">@lang('messages.city_local')</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-building text-gray-400"></i>
                            </div>
                            <input type="text" name="city" value=" {{ old('city', $address->city) }}"
                                class="w-full pl-10 rounded-lg border-gray-300 border px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all hover:border-gray-400">
                        </div>
                        @error('city') 
                            <span class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </span> 
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">@lang('messages.postal_code')</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-mailbox text-gray-400"></i>
                            </div>
                            <input type="text" name="zip_code" value=" {{ old('zip_code', $address->zip_code) }}"
                                class="w-full pl-10 rounded-lg border-gray-300 border px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all hover:border-gray-400">
                        </div>
                        @error('zip_code') 
                            <span class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </span> 
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                    <button type="button" onclick="window.history.back();" class="px-6 py-2.5 text-gray-600 font-medium hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-opacity-90 hover:-translate-y-0.5 transition-all shadow-sm flex items-center gap-2">
                        <i class="bi bi-arrow-repeat"></i> @lang('messages.update_address')
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection
