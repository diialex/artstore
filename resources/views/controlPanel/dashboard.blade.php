@extends('adminLayout')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex align-items-center mb-4">
        <h1 class="h2 mb-0">@lang('messages.metrics')</h1>
    </div>
    <div class="container">
        <h2>@lang('messages.user')</h2>
        <hr class="border-1 opacity-50">
        <div class="row">
            <div class="col-6">
                {!! $usersRegisterThisYear->container() !!}
            </div>
            <div class="col-6">
                {!! $ordersPerUser->container() !!}
            </div>
        </div>
    </div>
    
</div>

<script src="{{ $usersRegisterThisYear->cdn() }}"></script>
<script src="{{ $ordersPerUser->cdn() }}"></script>
{{ $usersRegisterThisYear->script() }}
{{ $ordersPerUser->script() }}
@endsection
