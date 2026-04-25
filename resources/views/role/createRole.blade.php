extends('layout')

<form action="{{ route('users.store') }}" method="POST">
@csrf {{-- Cláusula para obtener un token de formulario al enviarlo --}}
<input type="text" name="name" placeholder="name" value="{{ old('username') }}" class="form-control mb-2" autofocus>
@error('name') <div class="alert alert-danger"> No olvides rellenar el name
</div> @enderror
<input type="text" name="description" placeholder="description" value="{{ old('name') }}" class="form-control mb-2">
@error('name') <div class="alert alert-danger"> No olvides rellenar el description
</div> @enderror
<button class="btn btn-primary btn-block" type="submit">
Crear nuevo rol
</button></form>