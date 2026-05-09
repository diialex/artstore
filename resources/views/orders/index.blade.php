@extends('layout')
@section('title', 'Carrito')
@section('content')
    <div class="row m-4">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success my-2">{{ session('success') }}</div>
            @endif
        </div>
        @if(auth()->user()->role_id == 1)
            <a href="{{ route('orders.create') }}" class="btn btn-dark btn-sm rounded-pill px-4 tracking-wide">
                <i class="bi bi-plus-lg me-1"></i> NUEVA ORDEN (ADMIN)
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-dark border-0 rounded-4 py-3 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-bag-x display-1 text-light-emphasis"></i>
            <h3 class="fw-light mt-4">No tienes pedidos todavía</h3>
            <a href="{{ route('home') }}" class="btn btn-outline-dark rounded-pill px-5 mt-3 fw-bold">IR A LA TIENDA</a>
        </div>
    @else
        <div class="row g-3">
            @foreach($orders as $order)
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 hover-shadow transition-all">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                {{-- Info Principal --}}
                                <div class="col-md-3 border-end-md">
                                    <span class="text-muted x-small text-uppercase fw-bold ls-1">Referencia</span>
                                    <h5 class="fw-bold mb-0">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h5>
                                </div>

                                <div class="col-md-3 mt-3 mt-md-0">
                                    <span class="text-muted x-small text-uppercase fw-bold ls-1">Fecha</span>
                                    <p class="mb-0 fw-medium">{{ $order->created_at->format('d M, Y') }}</p>
                                </div>

                                <div class="col-md-2 mt-3 mt-md-0">
                                    <span class="text-muted x-small text-uppercase fw-bold ls-1">Total</span>
                                    <p class="mb-0 fw-bold fs-5 text-dark">{{ number_format($order->total_amount, 2) }} €</p>
                                </div>

                                <div class="col-md-2 mt-3 mt-md-0 text-center text-md-start">
                                    @php
                                        $statusStyles = match($order->status) {
                                            'completed', 'paid' => 'bg-success-subtle text-success border-success',
                                            'pending' => 'bg-warning-subtle text-warning border-warning',
                                            'failed' => 'bg-danger-subtle text-danger border-danger',
                                            default => 'bg-light text-dark border-secondary'
                                        };
                                    @endphp
                                    <span class="badge rounded-pill border px-3 py-2 fw-bold text-uppercase {{ $statusStyles }}" style="font-size: 0.65rem;">
                                        {{ $order->status }}
                                    </span>
                                </div>

                                {{-- Acciones --}}
                                <div class="col-md-2 mt-3 mt-md-0 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-light rounded-circle p-2" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                            <li><a class="dropdown-item py-2" href="{{ route('orders.show', $order) }}"><i class="bi bi-eye me-2"></i> Detalles</a></li>
                                            
                                            {{-- Solo el Admin ve estas opciones críticas --}}
                                            @if(auth()->user()->role_id == 1)
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item py-2 text-warning" href="{{ route('orders.edit', $order) }}"><i class="bi bi-pencil me-2"></i> Editar</a></li>
                                                <li>
                                                    <form method="POST" action="{{ route('orders.delete', $order) }}" onsubmit="return confirm('¿Eliminar pedido?');">
                                                        @csrf @method('DELETE')
                                                        <button class="dropdown-item py-2 text-danger"><i class="bi bi-trash me-2"></i> Eliminar</button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .ls-1 { letter-spacing: 1px; }
    .x-small { font-size: 0.7rem; }
    .transition-all { transition: all 0.3s ease; }
    .hover-shadow:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    @media (min-width: 768px) { .border-end-md { border-right: 1px solid #eee; } }
</style>
@endsection
