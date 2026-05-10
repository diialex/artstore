<?php

namespace App\Policies;

use App\Models\User;

class OrderItemsPolicy
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


    public function view(User $user): bool
    {
        return false;
    }


    public function create(User $user): bool
    {
        return false;
    }


    public function update(User $user): bool
    {
        return false;
    }


    public function delete(User $user): bool
    {
        return false;
    }
}
