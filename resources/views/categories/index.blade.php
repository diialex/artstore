@extends('layout')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>CategoradminLayoutías</h2>
            <a href="{{ route('categories.create') }}" class="btn btn-success">➕ Nueva Categoría</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td class="text-muted">{{ Str::limit($category->description, 60) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-warning btn-sm">✏️</a>
                                    
                                    <form action="{{ route('categories.delete', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Borrar categoría?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
