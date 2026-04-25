@extends('layout')

<form action="{{ route('users.store') }}" method="POST">
@csrf {{-- Cláusula para obtener un token de formulario al enviarlo --}}
<input type="text" name="name" placeholder="name" value="{{ old('name') }}" class="form-control mb-2" autofocus>
@error('name') <div class="alert alert-danger"> No olvides rellenar el nombre
</div> @enderror
<input type="text" name="email" placeholder="email" value="{{ old('email') }}" class="form-control mb-2">
@error('email') <div class="alert alert-danger"> No olvides rellenar el email
</div> @enderror
<input type="text" name="phone" placeholder="phone" value="{{ old('phone') }}" class="form-control mb-2">
@error('phone') <div class="alert alert-danger"> No olvides rellenar el phone
</div> @enderror
<input type="text" name="address" placeholder="address" value="{{ old('address') }}" class="form-control mb-2">
@error('address') <div class="alert alert-danger"> No olvides rellenar el address
</div> @enderror
<input type="password" name="password" placeholder="password">
@error('address') <div class="alert alert-danger"> No olvides rellenar el password
</div> @enderror
<input type="password" name="password_confirmation">
<select name="role">
    <option>selecciona colega plis</option>
    @foreach ($roles as $role)
        <option value="{{ $role->id }}">
            {{ $role->name }}
        </option>
    @endforeach
</select>
<button class="btn btn-primary btn-block" type="submit">
Crear nuevo usuario
</button></form>

