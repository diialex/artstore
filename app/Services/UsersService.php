<?php

namespace App\Services;

use App\Models\User;
use App\Models\FavoriteList;
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

    public function store($user){
        $user->saveOrFail();
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

    public function login($request){
        if(!$request->userCredential){
            return null;
        }
        if (filter_var($request->userCredential, FILTER_VALIDATE_EMAIL)){
            return User::where('email', $request->userCredential)->first();
        }else{
            return $this->getUserByUsername($request->userCredential);
        }
    }

    public function addFavorites($user_id ,$product_id ){
        $list = FavoriteList::firstOrCreate(['user_id' => $user_id]);
        $products_list= $list->products ?? [];

        if (!in_array($product_id, $products_list)){
            $products_list[] = $product_id;
        }

        $list->products = $products_list;
        $list->save();
    }
}