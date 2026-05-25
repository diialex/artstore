<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrdersPolicy
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


    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }



    public function create(User $user): bool
    {
        return $user->hasRol('user') || $user->hasRol('admin');
    }


    public function update(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

 
    public function delete(User $user, Order $order): bool
    {
        return false;
    }


    public function viewCarrito(User $user): bool
    {
        return $user->hasRol('user') || $user->hasRol('admin');
    }
}
