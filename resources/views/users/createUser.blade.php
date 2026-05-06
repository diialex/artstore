@extends('layout')

@section('title', 'Create user')
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

@foreach($roles as $role)
    <div class="form-check">
        <!-- El name debe ser igual para todos y terminar en [] -->
        <input class="form-check-input" 
               type="checkbox" 
               name="roles[]" 
               value="{{ $role->id }}" 
               id="role_{{ $role->id }}"
               {{ (is_array(old('roles')) && in_array($role->id, old('roles'))) ? 'checked' : '' }}>
        
        <label class="form-check-label" for="role_{{ $role->id }}">
            {{ $role->name }}
        </label>
    </div>
@endforeach
@error('roles[]') <div class="alert alert-danger"> Selecciona un rol </div> @enderror

<button class="btn btn-primary btn-block" type="submit">
Crear nuevo usuario
</button>
</form>
@endsection
