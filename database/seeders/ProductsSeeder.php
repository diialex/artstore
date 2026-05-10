<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear el primer producto
        $product1 = Product::create([
            'title' => 'Jordan 1 Retro High OG "Chicago"',
            'description' => 'Zapatillas de baloncesto icónicas con diseño retro y tecnología de puntera.',
            'price' => 150.00,
            'stock' => 10,
            'image_url' => 'storage/media/images/air-jordan-1-high-unc-toe-release.png'
        ]);
        // Adjuntar categorías por separado para no perder la instancia de $product1
        $product1->categories()->associate(2);
        $product1->categories()->associate(3);
        $product1->categories()->associate(4);

        // 2. Crear las tallas asociadas a este producto
        $product1->sizes()->createMany([
            ['size' => 'S', 'stock' => 10],
            ['size' => 'M', 'stock' => 20],
            ['size' => 'L', 'stock' => 15],
            ['size' => 'XL', 'stock' => 10],
        ]);

        // 3. Crear el segundo producto
        $product2 = Product::create([
            'title' => 'Converse Chuck Taylor All Star',
            'description' => 'Zapatillas clásicas y versátiles, ideales para cualquier estilo de vida.',
            'price' => 120.00,
            'stock' => 15,
            'image_url' => 'storage/media/images/daRealConverse.png'
        ]);
        $product2->categories()->associate(1);
        $product2->categories()->associate(5);

        // 4. Crear las tallas asociadas al segundo producto
        $product2->sizes()->createMany([
            ['size' => 'S', 'stock' => 10],
            ['size' => 'M', 'stock' => 20],
            ['size' => 'L', 'stock' => 15],
            ['size' => 'XL', 'stock' => 10],
        ]);
    }
}