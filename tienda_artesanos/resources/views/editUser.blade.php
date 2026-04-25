@extends('layout')

<form action="{{ route('users.update', $user->id) }}" method="POST">
@csrf
@method('PUT')
<input type="text" name="username" placeholder="username" value="{{ $user->username }}" class="form-control mb-2" autofocus>
@error('name') <div class="alert alert-danger"> No olvides rellenar el nusername
</div> @enderror
<input type="text" name="name" placeholder="name" value="{{ $user->name }}" class="form-control mb-2" autofocus>
@error('name') <div class="alert alert-danger"> No olvides rellenar el nombre
</div> @enderror
<input type="text" name="email" placeholder="email" value="{{ $user->email }}" class="form-control mb-2">
@error('email') <div class="alert alert-danger"> No olvides rellenar el email
</div> @enderror
<input type="text" name="phone" placeholder="phone" value="{{ $user->phone }}" class="form-control mb-2">
@error('phone') <div class="alert alert-danger"> No olvides rellenar el phone
</div> @enderror
<input type="text" name="address" placeholder="address" value="{{ $user->address }}" class="form-control mb-2">
@error('address') <div class="alert alert-danger"> No olvides rellenar el address
</div> @enderror
<input type="password" name="password" placeholder="password">
@error('address') <div class="alert alert-danger"> No olvides rellenar el password
</div> @enderror
<input type="password" name="password_confirmation">
<select name="role" class="form-control mb-2">
    @foreach ($roles as $role)
        <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
            {{ $role->name }}
        </option>
    @endforeach
</select>
<button class="btn btn-primary btn-block" type="submit">
editar</button></form>

