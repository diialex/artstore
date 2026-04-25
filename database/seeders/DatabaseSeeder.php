<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Creamos tu cuenta de Administrador (Problema 2)
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@artesanos.com',
            'password' => bcrypt('123456'), // Contraseña fácil para pruebas
            'is_admin' => true,
        ]);

        // 2. Creamos un Usuario normal para probar compras
        User::factory()->create([
            'name' => 'Cliente',
            'email' => 'cliente@artesanos.com',
            'password' => bcrypt('123456'),
            'is_admin' => false,
        ]);

        // 3. Fabricamos 5 categorías distintas
        $categories = Category::factory(5)->create();

        // 4. Fabricamos 30 productos y les asignamos categorías al azar
        Product::factory(30)->create()->each(function ($product) use ($categories) {
            // A cada producto le ponemos entre 1 y 2 categorías aleatorias
            $product->categories()->attach(
                $categories->random(rand(1, 2))->pluck('id')->toArray()
            );
        });
    }
}