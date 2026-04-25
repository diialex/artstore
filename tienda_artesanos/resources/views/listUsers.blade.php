@extends('layout')

@section('content')
<a href="{{ route('users.create') }}">Crear usuarios</a>
<div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
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
                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>
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
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No hay usuarios registrados
                        </td>
                    </tr>
                @endforelse

                @if (session('msg'))
                    <p>{{ session('msg') }}</p>
                @endif
                    
            </tbody>
        </table>
    </div>
@endsection