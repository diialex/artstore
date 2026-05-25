@extends('layout')

@section('title', 'Acceso no permitido')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="text-center">
        <div class="mb-4" style="font-size: 6rem; line-height: 1;">🚫</div>
        <h1 class="display-4 fw-bold text-danger mb-3">Acceso no permitido</h1>
        <p class="lead text-muted mb-4">
            No tienes permisos suficientes para acceder a esta sección.<br>
            Si crees que es un error, contacta con el administrador.
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-5">
            <i class="bi bi-house-door me-2"></i>Volver al inicio
        </a>
    </div>
</div>
@endsection
