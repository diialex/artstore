<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class RoleService
{
    public function getAll(): Collection
    {
        return Role::all();
    }
    
    public function get(string $id) : Role
    {
        $role = Role::find($id);
        if(!$role){
            throw new Exception("Role not exist");
        }
        return $role;
    }

    public function getUserByUsername(string $name) : Role
    {
        return Role::where('name', $name)->first();
    }

    public function update($user, $role){
        $user->save();

        $user->roles()->sync($role);
    }

    public function delete($user){
        $user->delete();
    }
}