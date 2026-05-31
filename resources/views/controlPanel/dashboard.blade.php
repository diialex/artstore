@extends('adminLayout')

@section('content')
<div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-10">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-3xl font-black text-dark tracking-tight">@lang('messages.metrics')</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">@lang('messages.gen_panel')</p>
        </div>
    </div>
    
    <div class="mb-10">
        <h2 class="text-lg font-bold text-gray-800 uppercase tracking-widest mb-6 flex items-center gap-2">
            <i class="bi bi-people-fill text-primary"></i> @lang('messages.user')
        </h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="mb-4">
                    <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wider">@lang('messages.year_registered')</h3>
                </div>
                <div class="w-full relative h-[300px]">
                    {!! $usersRegisterThisYear->container() !!}
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="mb-4">
                    <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wider">@lang('messages.orders_peruser')</h3>
                </div>
                <div class="w-full relative h-[300px]">
                    {!! $ordersPerUser->container() !!}
                </div>
            </div>
            
        </div>
    </div>
</div>

<script src="{{ $usersRegisterThisYear->cdn() }}"></script>
<script src="{{ $ordersPerUser->cdn() }}"></script>
{{ $usersRegisterThisYear->script() }}
{{ $ordersPerUser->script() }}
@endsection