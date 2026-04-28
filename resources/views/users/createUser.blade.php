@extends('layout')

@section('content')
<form action="{{ route('users.store') }}" method="POST">
@csrf {{-- Cláusula para obtener un token de formulario al enviarlo --}}
<input type="text" name="username" placeholder="username" value="{{ old('username') }}" class="form-control mb-2" autofocus>
@error('username') <div class="alert alert-danger"> No olvides rellenar el username </div> @enderror

<input type="text" name="name" placeholder="name" value="{{ old('name') }}" class="form-control mb-2">
@error('name') <div class="alert alert-danger"> No olvides rellenar el nombre </div> @enderror

<input type="text" name="email" placeholder="email" value="{{ old('email') }}" class="form-control mb-2">
@error('email') <div class="alert alert-danger"> No olvides rellenar el email </div> @enderror

<input type="text" name="phone" placeholder="phone" value="{{ old('phone') }}" class="form-control mb-2">
@error('phone') <div class="alert alert-danger"> No olvides rellenar el phone </div> @enderror

<input type="password" name="password" placeholder="password" class="form-control mb-2">
@error('password') <div class="alert alert-danger"> No olvides rellenar el password </div> @enderror

<input type="password" name="password_confirmation" placeholder="confirm password" class="form-control mb-2">

<select name="role" class="form-control mb-2">
    <option value="">Selecciona un rol</option>
    @foreach ($roles as $role)
        <option value="{{ $role->id }}">
            {{ $role->name }}
        </option>
    @endforeach
</select>
@error('role') <div class="alert alert-danger"> Selecciona un rol </div> @enderror

<button class="btn btn-primary btn-block" type="submit">
Crear nuevo usuario
</button>
</form>
@endsection
