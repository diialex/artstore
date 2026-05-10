<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Address;

class AddressesPolicy
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
     * Ver listado de direcciones — solo admin (gestionado por before()).
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Ver una dirección — el propietario.
     */
    public function view(User $user, Address $address): bool
    {
        return $user->id === $address->user_id;
    }

    /**
     * Crear una dirección — cualquier usuario autenticado.
     */
    public function create(User $user): bool
    {
        return $user->hasRol('user') || $user->hasRol('admin');
    }

    /**
     * Actualizar una dirección — el propietario.
     */
    public function update(User $user, Address $address): bool
    {
        return $user->id === $address->user_id;
    }

    /**
     * Eliminar una dirección — el propietario.
     */
    public function delete(User $user, Address $address): bool
    {
        return $user->id === $address->user_id;
    }
}
