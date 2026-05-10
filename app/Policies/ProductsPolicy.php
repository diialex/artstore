<?php

namespace App\Policies;

use App\Models\User;

class ProductsPolicy
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
     * Ver listado de productos (home / catálogo) — cualquier usuario autenticado puede.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRol('user') || $user->hasRol('admin');
    }

    /**
     * Ver un producto concreto — cualquier usuario autenticado puede.
     */
    public function view(User $user): bool
    {
        return $user->hasRol('user') || $user->hasRol('admin');
    }

    /**
     * Crear producto — solo admin (gestionado por before()).
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Actualizar producto — solo admin (gestionado por before()).
     */
    public function update(User $user): bool
    {
        return false;
    }

    /**
     * Eliminar producto — solo admin (gestionado por before()).
     */
    public function delete(User $user): bool
    {
        return false;
    }
}
