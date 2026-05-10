<?php

namespace App\Policies;

use App\Models\User;

class OrderItemsPolicy
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
     * Ver listado de order items — solo admin (gestionado por before()).
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Ver un order item — solo admin (gestionado por before()).
     */
    public function view(User $user): bool
    {
        return false;
    }

    /**
     * Crear order item — solo admin (gestionado por before()).
     * Los usuarios añaden productos al carrito mediante OrdersPolicy.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Actualizar order item — solo admin (gestionado por before()).
     */
    public function update(User $user): bool
    {
        return false;
    }

    /**
     * Eliminar order item — solo admin (gestionado por before()).
     */
    public function delete(User $user): bool
    {
        return false;
    }
}
