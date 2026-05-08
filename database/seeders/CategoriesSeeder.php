<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Mujer',
            'description' => 'Zapatillas de baloncesto icónicas con diseño retro y tecnología de puntera.',
            'image' => 'media/images/woman.png'
        ]);

        Category::create([
            'name' => 'Hombre',
            'description' => 'Zapatillas clásicas y versátiles, ideales para cualquier estilo de vida.',
            'image' => 'media/images/man.png'
        ]);

        Category::create([
            'name' => 'Jordans',
            'description' => 'Zapatillas clásicas y versátiles, ideales para cualquier estilo de vida.',
            'image' => 'media/images/jordans.png'
        ]);

        Category::create([
            'name' => 'Nuevo',
            'description' => 'Últimas novedades en tienda.',
            'image' => 'media/images/new.png'
        ]);

        Category::create([
            'name' => 'Rebajas',
            'description' => 'Productos con descuento.',
            'image' => 'media/images/sales.png'
        ]);
    }
}
