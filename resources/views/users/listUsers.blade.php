@extends('layout')

@section('content')

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Crear usuarios</a>
    <a href="{{ route('roles.create') }}" class="btn btn-secondary mb-3">Crear rol</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre de usuario</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
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

                        <td>
                            @forelse($user->roles as $role)
                                <span class="badge bg-info">{{ $role->name }}</span>
                            @empty
                                <span class="badge bg-secondary">Sin roles</span>
                            @endforelse
                        </td>

                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('users.edit', $user->username) }}" class="btn btn-sm btn-primary">Editar</a>

                                <a href="{{ route('addresses.show', $user->username) }}" class="btn btn-sm btn-info text-white">
                                    Direcciones
                                </a>

                                <form action="{{ route('users.delete', $user->username) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Estás seguro de borrar a {{ $user->username }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Borrar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
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