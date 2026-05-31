@extends('auth.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-info text-white">@lang('messages.mypanel')</div>
            <div class="card-body text-center">
                <h3 class="mb-4">@lang('messages.welcome_init') {{ auth()->user()->name }}!</h3>
                <p>@lang('messages.success_login')</p>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">@lang('messages.logout')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection