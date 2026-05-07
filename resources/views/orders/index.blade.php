@extends('layout')
@section('title', 'Carrito')
@section('content')
    <div class="row m-4">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success my-2">{{ session('success') }}</div>
            @endif
        </div>

        <div class="col-12 mt-4">
            @if($orders->isEmpty())
                <p>No existe ningún producto en el carrito.</p>
            @else
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
            @endif

        </div>
    </div>
    @endsection
