<x-layout>
    <div class="row m-4">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success my-2">{{ session('success') }}</div>
            @endif

            <a href="{{ route('orderitems.create') }}" class="btn btn-primary">Nueva Orden</a>
        </div>

        <div class="col-12 mt-4">
            <ul>
                @foreach($orderitems as $orderitem)
                    <li class="mb-2">
                        <strong>Orden #{{ $orderitem->id }}</strong> - ${{ $orderitem->total_amount }} ({{ $orderitem->status }})
                        <a href="{{ route('orderitems.edit', $orderitem) }}" class="btn btn-warning">Editar</a>
                        <form method="POST" action="{{ route('orderitems.delete', $orderitem) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger">Eliminar</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layout>
