<x-layout>

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
                            <td>{{ $item->product->name }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                            <td>
                                <form action="{{ route('orderitems.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este item?');">
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
                <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary">Proceder al Checkout</a>
            </div>
        @endif
    </div>



</x-layout>