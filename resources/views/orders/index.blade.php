<x-layout>
    <div class="row m-4">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success my-2">{{ session('success') }}</div>
            @endif

            <a href="{{ route('orders.create') }}" class="btn btn-primary">Nueva Orden</a>
        </div>

        <div class="col-12 mt-4">
            <ul>
                @foreach($orders as $order)
                    <li class="mb-2">
                        <strong>Orden #{{ $order->id }}</strong> - ${{ $order->total_amount }} ({{ $order->status }})
                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">Editar</a>
                        <form method="POST" action="{{ route('orders.delete', $order) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger">Eliminar</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layout>
