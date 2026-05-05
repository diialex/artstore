@extends('layout')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="container-fluid mt-4">
    <div class="d-flex align-items-center mb-4">
        <!-- Botón del menú -->
        <button class="btn btn-dark me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling">
            <i class="bi bi-list fs-4"></i>
        </button>
        <!-- Título -->
        <h1 class="h2 mb-0">Panel de Administración</h1>
    </div>
    <div class="offcanvas-body">
        <p>Try scrolling the rest of the page to see this option in action.</p>
    </div>
</div>
@endsection
