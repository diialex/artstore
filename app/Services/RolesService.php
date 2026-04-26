<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class RolesService
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

    public function store(Role $role){
        $role->saveOrFail();
    }

    public function getUserByName(string $name) : Role
    {
        return Role::where('name', $name)->first();
    }

    public function update(Role $role){
        $role->save();
    }

    public function delete(Role $role){
        $role->delete();
    }
}