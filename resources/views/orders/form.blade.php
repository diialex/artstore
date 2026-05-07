@extends('layout')
@section('title', $order->id ? 'Editar Orden' : 'Nueva Orden')
@section('content')
    <div class="row m-4">
        <div class="col-6">
            <h3>{{ $order->id ? 'Editar Orden' : 'Nueva Orden' }}</h3>

            <form action="{{ $order->id ? route('orders.update', $order) : route('orders.store') }}" method="POST">
                @csrf
                @if($order->id)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="total_amount" class="form-label">Cantidad Total</label>
                    <input type="number" step="0.01" class="form-control @error('total_amount') is-invalid @enderror" id="total_amount" name="total_amount" value="{{ old('total_amount', $order->total_amount) }}">
                    @error('total_amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Estado</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="">Selecciona un estado</option>
                        <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completada</option>
                        <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="shipping_address" class="form-label">Dirección de Envío</label>
                    <input type="text" class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" value="{{ old('shipping_address', $order->shipping_address) }}">
                    @error('shipping_address')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ $order->id ? 'Actualizar' : 'Crear' }}</button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
