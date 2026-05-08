@extends('layout')
@section('content')
    <div>
        <h1 class="mb-4">Carrito de Compras</h1>

        @if(!$order || $order->items->isEmpty())
            <p>Tu carrito está vacío.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->title }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                            <td>
                                <form action="{{ route('orderitems.delete', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                <h4>Total: ${{ number_format($order->total_amount, 2) }}</h4>
                <form method="post" action="{{ route('payments.pay', $order) }}">
                    @csrf
                    <select>
                    @foreach ($order->user->addresses as $address)
                        <option name="address_id" value="{{ $address->$id }}" {{ $loop->first ? 'selected' : '' }}>
                            <b>{{ $address->street }}</b>, {{ $address->city }}, {{ $address->zip_code }}
                        </option>
                    @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Pagar</button>
                </form>
            </div>
        @endif
    </div>
@endsection