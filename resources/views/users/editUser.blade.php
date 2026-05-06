@extends('layout')

@section('title', 'Editar Usuario')

@section('content')
<form action="{{ route('users.update', $user->id) }}" method="POST">
@csrf
@method('PUT')
<input type="text" name="username" placeholder="username" value="{{ $user->username }}" class="form-control mb-2" autofocus>
@error('username') <div class="alert alert-danger"> No olvides rellenar el username </div> @enderror

<input type="text" name="name" placeholder="name" value="{{ $user->name }}" class="form-control mb-2">
@error('name') <div class="alert alert-danger"> No olvides rellenar el nombre </div> @enderror

<input type="text" name="email" placeholder="email" value="{{ $user->email }}" class="form-control mb-2">
@error('email') <div class="alert alert-danger"> No olvides rellenar el email </div> @enderror

<input type="text" name="phone" placeholder="phone" value="{{ $user->phone }}" class="form-control mb-2">
@error('phone') <div class="alert alert-danger"> No olvides rellenar el phone </div> @enderror

<input type="password" name="password" placeholder="password (dejar en blanco para no cambiar)" class="form-control mb-2">
@error('password') <div class="alert alert-danger"> Error en la contraseña </div> @enderror

<input type="password" name="password_confirmation" placeholder="confirmar password" class="form-control mb-2">

<select name="role" class="form-control mb-2">
    @foreach ($roles as $role)
        <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
            {{ $role->name }}
        </option>
    @endforeach
</select>
@error('role') <div class="alert alert-danger"> Selecciona un rol </div> @enderror

<button class="btn btn-primary btn-block" type="submit">
Editar usuario
</button>
</form>
@endsection
