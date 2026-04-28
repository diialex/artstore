<x-layout>

    <div>
        <h1 class="mb-4">Carrito de Compras</h1>

        @if($orders->isEmpty())
            <p>Tu carrito está vacío.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID de Orden</th>
                        <th>Cantidad Total</th>
                        <th>Estado</th>
                        <th>Dirección de Envío</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ $order->shipping_address }}</td>
                            <td>
                                <!-- Aquí puedes agregar botones para editar o eliminar la orden -->
                                <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-warning btn-sm">
                                    Editar
                                </a>

                                <!-- Botón para eliminar la orden -->
                                <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta orden?');">
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
        @endif
    </div>



</x-layout>