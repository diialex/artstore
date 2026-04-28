@extends('layout')

@section('content')
<form action="{{ route('addresses.store') }}" method="POST">
@csrf

@if(isset($userId))
    <input type="hidden" name="user_id" value="{{ $userId }}">
@else
    <select name="user_id" class="form-control mb-2">
        <option value="">Selecciona un usuario</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
        @endforeach
    </select>
    @error('user_id') <div class="alert alert-danger"> Selecciona un usuario </div> @enderror
@endif

<input type="text" name="street" placeholder="Calle" value="{{ old('street') }}" class="form-control mb-2" autofocus>
@error('street') <div class="alert alert-danger"> Rellena la calle </div> @enderror

<input type="text" name="city" placeholder="Ciudad" value="{{ old('city') }}" class="form-control mb-2">
@error('city') <div class="alert alert-danger"> Rellena la ciudad </div> @enderror

<input type="text" name="zip_code" placeholder="Código Postal" value="{{ old('zip_code') }}" class="form-control mb-2">
@error('zip_code') <div class="alert alert-danger"> Rellena el código postal </div> @enderror

<button class="btn btn-primary btn-block" type="submit">
Crear nueva dirección
</button>
</form>
@endsection
