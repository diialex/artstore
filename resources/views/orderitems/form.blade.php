@extends('layout')
    <div class="row m-4">
        <div class="col-6">
            <h3>{{ $orderItem->id ? __('messages.edit_artc_order') : __('messages.new_artc_order') }}</h3>

            <form action="{{ $orderItem->id ? route('orderitems.update', $orderItem) : route('orderitems.store') }}"
                method="POST">
                @csrf
                @if($orderItem->id)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="order_id" class="form-label">Orden</label>
                    <select class="form-control @error('order_id') is-invalid @enderror" id="order_id" name="order_id" required>
                        <option value="">@lang('messages.select_order')</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" {{ old('order_id', $orderItem->order_id) == $order->id ? 'selected' : '' }}>
                                Order #{{ $order->id }} - ${{ $order->total_amount }}
                            </option>
                        @endforeach
                    </select>
                    @error('order_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">@lang('messages.amount')</label>
                    <input type="number" step="1" class="form-control @error('quantity') is-invalid @enderror"
                        id="quantity" name="quantity" required
                        value="{{ old('quantity', $orderItem->quantity) }}">
                    @error('quantity')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">@lang('messages.unit_price')</label>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                        id="price" name="price" required
                        value="{{ old('price', $orderItem->price) }}">
                    @error('price')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ $orderItem->id ? __('messages.update') : __('messages.crear') }}</button>
                <a href="{{ route('orderitems.index') }}" class="btn btn-secondary">@lang('messages.cancel')</a>
            </form>
        </div>
    </div>