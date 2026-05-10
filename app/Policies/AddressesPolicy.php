<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Address;

class AddressesPolicy
{

    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRol('admin')) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }


    public function view(User $user, Address $address): bool
    {
        return $user->id === $address->user_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRol('user') || $user->hasRol('admin');
    }


    public function update(User $user, Address $address): bool
    {
        return $user->id === $address->user_id;
    }


    public function delete(User $user, Address $address): bool
    {
        return $user->id === $address->user_id;
    }
}
