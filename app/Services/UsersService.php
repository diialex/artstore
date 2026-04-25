<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class UsersService
{
    public function getAll(): Collection
    {
        return User::all();
    }
    
    public function get(string $id) : User
    {
        $user = User::find($id);
        if(!$user){
            throw new Exception("Usuario no existe");
        }
        return $user;
    }

    public function getUserByUsername(string $username) : User
    {
        return User::where('username', $username)->first();
    }

    public function update($user, $role){
        $user->save();

        $user->roles()->sync($role);
    }

    public function delete($user){
        $user->delete();
    }
}