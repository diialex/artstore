@extends('layout')

@section('content')
    <form action="{{ route('addresses.store') }}" method="POST">
        @csrf
        <input type="text" name="street" placeholder="Calle" value="{{ old('street') }}" class="form-control mb-2"
            autofocus>
        @error('street') <div class="alert alert-danger"> Rellena la calle </div> @enderror

        <input type="text" name="city" placeholder="Ciudad" value="{{ old('city') }}" class="form-control mb-2">
        @error('city') <div class="alert alert-danger"> Rellena la ciudad </div> @enderror

        <input type="text" name="zip_code" placeholder="Código Postal" value="{{ old('zip_code') }}"
            class="form-control mb-2">
        @error('zip_code') <div class="alert alert-danger"> Rellena el código postal </div> @enderror

        <button class="btn btn-primary btn-block" type="submit">
            Crear nueva dirección
        </button>
    </form>
@endsection