<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //admin
        User::create([
            'id'=> 1,
            'name'=>'Ramón López Álvarez',
            'username'=> 'ralopalv01',
            'email'=>'ralopalv01@gmail.com',
            'password'=>User::encryptPassword('ralopalv01'),
            'phone'=>'111111111'
        ])->roles()->save(Role::find(1));
        
        //user
        User::create([
            'id'=> 2,
            'name'=>'Paula Dolado Aynié',
            'username'=> 'padolayn02',
            'email'=>'padolayn02@gmail.com',
            'password'=>User::encryptPassword('padolayn02'),
            'phone'=>'222222222'
        ])->roles()->save(Role::find(2));

        //admin user
        User::create([
            'id'=> 3,
            'name'=> 'Manuel Revuelta Reyes',
            'username'=>'marevrey03',
            'email'=>'marevrey03@gmail.com',
            'password'=>User::encryptPassword('marevrey03'),
            'phone'=>'333333333'
        ])->roles()->saveMany([Role::find(1), Role::find(2)]);
    }
}
