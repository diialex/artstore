@extends('adminLayout')

@section('content')
<div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-10">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-3xl font-black text-dark tracking-tight">@lang('messages.metrics')</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">@lang('messages.gen_panel')</p>
        </div>
    </div>

    {{-- ===================== VENTAS ===================== --}}
    <div class="mb-10">
        <h2 class="text-lg font-bold text-gray-800 uppercase tracking-widest mb-6 flex items-center gap-2">
            <i class="bi bi-graph-up-arrow text-primary"></i> @lang('messages.sales')
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wider mb-4">@lang('messages.revenue_per_month')</h3>
                <div class="w-full">
                    {!! $revenuePerMonth->container() !!}
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wider mb-4">@lang('messages.top_products')</h3>
                <div class="w-full">
                    {!! $topProducts->container() !!}
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wider mb-4">@lang('messages.revenue_by_category')</h3>
                <div class="w-full flex justify-center">
                    {!! $revenueByCategory->container() !!}
                </div>
            </div>

        </div>
    </div>

    {{-- ===================== USUARIOS ===================== --}}
    <div class="mb-10">
        <h2 class="text-lg font-bold text-gray-800 uppercase tracking-widest mb-6 flex items-center gap-2">
            <i class="bi bi-people-fill text-primary"></i> @lang('messages.user')
        </h2>

        <div class="grid grid-cols-1 gap-6">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wider mb-4">@lang('messages.year_registered')</h3>
                <div class="w-full">
                    {!! $usersRegisterThisYear->container() !!}
                </div>
            </div>

        </div>
    </div>
</div>

<script src="{{ $revenuePerMonth->cdn() }}"></script>
{{ $revenuePerMonth->script() }}
{{ $topProducts->script() }}
{{ $revenueByCategory->script() }}
{{ $usersRegisterThisYear->script() }}
@endsection
