@extends('layout')

@section('title', 'Create roles')

@section('content')

<form action="{{ route('roles.store') }}" method="POST">
@csrf {{-- Cláusula para obtener un token de formulario al enviarlo --}}
<input type="text" name="name" placeholder="name" value="{{ old('name') }}" class="form-control mb-2" autofocus>
@error('name') <div class="alert alert-danger"> No olvides rellenar el name
</div> @enderror
<input type="text" name="description" placeholder="description" value="{{ old('description') }}" class="form-control mb-2">
@error('description') <div class="alert alert-danger"> No olvides rellenar el description
</div> @enderror
<button class="btn btn-primary btn-block" type="submit">
Crear nuevo rol
</button></form>

@if (session('msg'))
    <div class="alert alert-success mt-3">
        {{ session('msg') }}
    </div>
@endif

@endsection