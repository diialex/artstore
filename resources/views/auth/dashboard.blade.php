@extends('auth.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-info text-white">Mi Panel (Dashboard)</div>
            <div class="card-body text-center">
                <h3 class="mb-4">¡Bienvenido, {{ auth()->user()->name }}!</h3>
                <p>Has iniciado sesión correctamente.</p>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection