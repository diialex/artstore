<?php

namespace App\Policies;

use App\Models\User;

class UsersPolicy
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
     * Ver listado de usuarios — solo admin (gestionado por before()).
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Ver un perfil de usuario — el propio usuario o admin.
     */
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * Crear usuario — solo admin (gestionado por before()).
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Actualizar usuario — el propio usuario puede editar su perfil.
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * Eliminar usuario — solo admin (gestionado por before()).
     */
    public function delete(User $user, User $model): bool
    {
        return false;
    }
}
