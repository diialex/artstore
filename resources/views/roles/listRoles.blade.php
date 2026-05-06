@extends('layout')

@section('title', 'Roles')

@section('content')

    <a href="{{ route('roles.create') }}">Crear usuarios</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>

            <tbody>

                @forelse($roles as $role)
                    <tr>
                        <td><strong>{{ $role->name }}</strong></td>
                        <td>{{ $role->description }}</td>
                        <td>
                            <a href="{{ route('roles.edit', $role->id) }}">actualizar role</a>
                        </td>
                        <td>
                            <form method="post" action="{{ route('roles.delete', $role->id) }}"
                                onsubmit="return confirm('¿Estás seguro de borrar el rol {{ $role->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">eliminar</button>

                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No hay roles registrados
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