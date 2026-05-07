@extends('layout')

@section('title', 'Addresses')

@section('content')

<a href="{{ route('addresses.create', isset($userId) ? ['user_id' => $userId] : []) }}" class="btn btn-primary mb-3">Crear dirección</a>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Usuario</th>
                <th>Calle</th>
                <th>Ciudad</th>
                <th>Código Postal</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse($addresses as $address)
                <tr>
                    <td><strong>{{ $address->user->username ?? 'Sin usuario' }}</strong></td>
                    <td>{{ $address->street }}</td>
                    <td>{{ $address->city }}</td>
                    <td>{{ $address->zip_code }}</td>

                    <td>
                        <a href="{{ route('addresses.edit', $address->id) }}">actualizar dirección</a>
                        <form action="{{ route('addresses.delete', $address->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de borrar esta dirección?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Borrar
                                </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        No hay direcciones registradas
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>

@if (session('msg'))
    <div class="alert alert-success mt-3">
        {{ session('msg') }}
    </div>
@endif

@endsection
