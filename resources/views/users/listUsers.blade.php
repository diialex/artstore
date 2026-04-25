@extends('layout')

@section('content')

<a href="{{ route('users.create') }}">Crear usuarios</a>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nombre de usuario</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Roles</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse($users as $user)
                <tr>
                    <td><strong>{{ $user->username }}</strong></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->address }}</td>

                    <td>
                        @forelse($user->roles as $role)
                            <span class="badge bg-info">{{ $role->name }}</span>
                        @empty
                            <span class="badge bg-secondary">Sin roles</span>
                        @endforelse
                    </td>

                    <td>
                        <a href="{{ route('users.edit', $user->id) }}">actualizar usuario</a>
                        <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de borrar a {{ $user->username }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Borrar
                                </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        No hay usuarios registrados
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