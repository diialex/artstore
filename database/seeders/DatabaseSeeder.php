<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<< HEAD
        // 1. Creamos tu cuenta de Administrador (Problema 2)
        User::create([
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@artesanos.com',
            'password' => bcrypt('123456'), // Contraseña fácil para pruebas
            'phone' => '1234567890',
        ]);

        // 2. Creamos un Usuario normal para probar compras
        User::create([
            'username'=> 'client',
            'name' => 'Cliente',
            'email' => 'cliente@artesanos.com',
            'password' => bcrypt('123456'),
            'phone' => '0987654321',
        ]);

        $this->call(ProductSeeder::class);
=======
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
        ]);
>>>>>>> main
    }
}
