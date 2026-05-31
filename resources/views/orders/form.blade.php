@extends('layout')
@section('title', $order->id ? __('message.editorder') : __('message.neworder'))
@section('content')
    <div class="row m-4">
        <div class="col-6">
            <h3>{{ $order->id ? __('message.editorder') : __('message.neworder') }}</h3>

            <form action="{{ $order->id ? route('orders.update', $order) : route('orders.store') }}" method="POST">
                @csrf
                @if($order->id)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="total_amount" class="form-label">@lang('messages.total_amount')</label>
                    <input type="number" step="0.01" class="form-control @error('total_amount') is-invalid @enderror" id="total_amount" name="total_amount" value="{{ old('total_amount', $order->total_amount) }}">
                    @error('total_amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">@lang('messages.status')</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="">@lang('messages.select_state')</option>
                        <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>@lang('messages.pending')</option>
                        <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>@lang('messages.completed')</option>
                        <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>@lang('messages.cancelled')</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="shipping_address" class="form-label">@lang('messages.sendaddress')</label>
                    <input type="text" class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" value="{{ old('shipping_address', $order->shipping_address) }}">
                    @error('shipping_address')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ $order->id ? __('message.update') : __('message.crear') }}</button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">@lang('messages.cancel')</a>
            </form>
        </div>
    </div>
    @endsection
