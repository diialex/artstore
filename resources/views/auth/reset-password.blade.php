@extends('auth.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-danger text-white">@lang('messages.createnewpass')</div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ request()->route('token') }}">
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ request()->email }}" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">@lang('messages.newpass')</label>
                        <input type="password" class="form-control" id="password" name="password" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">@lang('messages.confirm_password')</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">@lang('messages.resetpass')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection