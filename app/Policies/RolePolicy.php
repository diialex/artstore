<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy
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

   
    public function view(User $user, Role $rol): bool
    {
        return false;
    }

   
    public function create(User $user): bool
    {
        return false;
    }

   
    public function update(User $user, Role $rol): bool
    {
        return false;
    }

    
    public function delete(User $user, Role $rol): bool
    {
        return false;
    }

    
    public function restore(User $user, Role $rol): bool
    {
        return false;
    }

    public function forceDelete(User $user, Role $rol): bool
    {
        return false;
    }
}
