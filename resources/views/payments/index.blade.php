@extends('adminLayout')
@section('content')
    <div class="row m-4">
        <div class="col-12">
            @if(session('message'))
                <div class="alert alert-secondary my-2">{{ session('message') }}</div>
            @endif

            <a href="{{ route('payments.create') }}" class="btn btn-primary">@lang('messages.create_payment')</a>
        </div>

        <div class="col-12 mt-4">
            <ul>
                @foreach($payments as $payment)
                    <li class="mb-2">
                        <strong>{{ $payment->title }}</strong> ({{ $payment->status }})
                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning">@lang('messages.edit')</a>
                        <form method="POST" action="{{ route('payments.delete', $payment) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger">@lang('messages.delete')</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection