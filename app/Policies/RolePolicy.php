<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy
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
     * Ver listado de roles — solo admin (gestionado por before()).
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Ver un rol concreto — solo admin (gestionado por before()).
     */
    public function view(User $user, Role $rol): bool
    {
        return false;
    }

    /**
     * Crear un rol — solo admin (gestionado por before()).
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Actualizar un rol — solo admin (gestionado por before()).
     */
    public function update(User $user, Role $rol): bool
    {
        return false;
    }

    /**
     * Eliminar un rol — solo admin (gestionado por before()).
     */
    public function delete(User $user, Role $rol): bool
    {
        return false;
    }

    /**
     * Restaurar un rol — solo admin (gestionado por before()).
     */
    public function restore(User $user, Role $rol): bool
    {
        return false;
    }

    /**
     * Eliminar permanentemente un rol — solo admin (gestionado por before()).
     */
    public function forceDelete(User $user, Role $rol): bool
    {
        return false;
    }
}
