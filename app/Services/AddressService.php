<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AddressService {
    
    public function getAll(): Collection 
    {
        return Address::all();
    }

    public function get(int $id): Address 
    {
        return Address::findOrFail($id);
    }

    public function create(User $user, array $data): Address 
    {
        return $user->addresses()->create($data);
    }

    public function update(User $user, Address $address, array $data): bool 
    {
        if ($address->user_id !== $user->id) {
            return false; 
        }

        return $address->update($data);
    }

    public function delete(Address $address): bool 
    {
        return $address->delete();
    }
}