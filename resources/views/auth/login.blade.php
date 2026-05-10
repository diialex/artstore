@extends('auth.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">Iniciar Sesión</div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger mt-3 mb-0 p-2">
                        Credenciales incorrectas.
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="userCredential" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userCredential" name="userCredential" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" placeholder="*****" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a> | 
                    <a href="{{ route('register') }}">Crear una cuenta</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection