<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Creamos 5 categorías
        $categories = Category::factory(5)->create();

        // 2. Creamos 20 productos
        Product::factory(20)->create()->each(function ($product) use ($categories) {
            // A cada producto le asignamos entre 1 y 2 categorías al azar
            $product->categories()->attach(
                $categories->random(rand(1, 2))->pluck('id')->toArray()
            );

            // De paso, le creamos un par de tallas falsas para que no den error tus vistas
            $product->sizes()->create(['size' => 'Única', 'stock' => rand(5, 50)]);
        });
    }
}