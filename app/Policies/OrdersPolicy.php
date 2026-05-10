<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrdersPolicy
{
    /**
     * Admin tiene acceso total a cualquier acción antes de evaluar las demás.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRol('admin')) {
            return true;
        }
        return null;
    }

    /**
     * Ver listado de órdenes — solo admin (gestionado por before()).
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Ver una orden concreta — el propietario o admin.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    /**
     * Crear/iniciar una compra — cualquier usuario autenticado con rol user.
     */
    public function create(User $user): bool
    {
        return $user->hasRol('user') || $user->hasRol('admin');
    }

    /**
     * Actualizar orden (añadir/quitar items del carrito) — el propietario.
     */
    public function update(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    /**
     * Eliminar orden — solo admin (gestionado por before()).
     */
    public function delete(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Acceder al carrito — cualquier usuario autenticado con rol user.
     */
    public function viewCarrito(User $user): bool
    {
        return $user->hasRol('user') || $user->hasRol('admin');
    }
}
