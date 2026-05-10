<?php

namespace App\Policies;

use App\Models\User;

class PaymentsPolicy
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
     * Ver listado de pagos — solo admin (gestionado por before()).
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Ver un pago concreto — solo admin (gestionado por before()).
     */
    public function view(User $user): bool
    {
        return false;
    }

    /**
     * Realizar un pago (checkout) — cualquier usuario autenticado con rol user.
     */
    public function create(User $user): bool
    {
        return $user->hasRol('user') || $user->hasRol('admin');
    }

    /**
     * Actualizar pago — solo admin (gestionado por before()).
     */
    public function update(User $user): bool
    {
        return false;
    }

    /**
     * Eliminar pago — solo admin (gestionado por before()).
     */
    public function delete(User $user): bool
    {
        return false;
    }
}
