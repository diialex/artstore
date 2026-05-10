<?php

namespace App\Policies;

use App\Models\User;

class ProductsPolicy
{

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
