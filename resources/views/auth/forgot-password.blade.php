@extends('auth.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">Recuperar Contraseña</div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <p>¿Olvidaste tu contraseña? No hay problema. Déjanos tu email y te enviaremos un enlace!!.</p>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Enviar enlace al email</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection