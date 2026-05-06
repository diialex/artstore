@extends('layout')

@section('title', 'Edit address')

@section('content')
<form action="{{ route('addresses.update', $address->id) }}" method="POST">
@csrf
@method('PUT')

<select name="user_id" class="form-control mb-2">
    @foreach ($users as $user)
        <option value="{{ $user->id }}" {{ $address->user_id == $user->id ? 'selected' : '' }}>
            {{ $user->username }}
        </option>
    @endforeach
</select>
@error('user_id') <div class="alert alert-danger"> Selecciona un usuario </div> @enderror

<input type="text" name="street" placeholder="Calle" value="{{ $address->street }}" class="form-control mb-2" autofocus>
@error('street') <div class="alert alert-danger"> Rellena la calle </div> @enderror

<input type="text" name="city" placeholder="Ciudad" value="{{ $address->city }}" class="form-control mb-2">
@error('city') <div class="alert alert-danger"> Rellena la ciudad </div> @enderror

<input type="text" name="zip_code" placeholder="Código Postal" value="{{ $address->zip_code }}" class="form-control mb-2">
@error('zip_code') <div class="alert alert-danger"> Rellena el código postal </div> @enderror

<button class="btn btn-primary btn-block" type="submit">
Editar dirección
</button>
</form>
@endsection
