<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'id' => 2,
            'name'=>'user',
            'description'=>'rol for user'
        ]);

        Role::create([
            'id'=> 1,
            'name'=>'admin',
            'description'=>'rol for admin'
        ]);
    }
}
