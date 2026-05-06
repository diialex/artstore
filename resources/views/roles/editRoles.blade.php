@extends('layout')

@section('title', 'Edit roles')

@section('content')

<form action="{{ route('roles.update', $role->id) }}" method="POST">
@csrf
@method('PUT')
<input type="text" name="name" placeholder="name" value="{{ old('name', $role->name) }}" class="form-control mb-2" autofocus>
@error('name') <div class="alert alert-danger"> No olvides rellenar el name
</div> @enderror
<input type="text" name="description" placeholder="description" value="{{ old('description', $role->description) }}" class="form-control mb-2">
@error('description') <div class="alert alert-danger"> No olvides rellenar el description
</div> @enderror
<button class="btn btn-primary btn-block" type="submit">
Actualizar rol
</button></form>

@if (session('msg'))
    <div class="alert alert-success mt-3">
        {{ session('msg') }}
    </div>
@endif

@endsection
