<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $product1 = Product::create([
            'title' => 'Jordan 1 Retro High OG "Chicago"',
            'description' => 'Zapatillas de baloncesto icónicas con diseño retro y tecnología de puntera.',
            'price' => 150.00,
            'image_url' => 'storage/media/images/air-jordan-1-high-unc-toe-release.png'
        ]);
        $product1->categories()->attach(2);
        $product1->categories()->attach(3);
        $product1->categories()->attach(4);

        $product1->sizes()->createMany([
            ['size' => 'S', 'stock' => 10],
            ['size' => 'M', 'stock' => 20],
            ['size' => 'L', 'stock' => 15],
            ['size' => 'XL', 'stock' => 10],
        ]);

        $product2 = Product::create([
            'title' => 'Converse Chuck Taylor All Star',
            'description' => 'Zapatillas clásicas y versátiles, ideales para cualquier estilo de vida.',
            'price' => 120.00,
            'image_url' => 'storage/media/images/daRealConverse.png'
        ]);
        $product2->categories()->attach(1);
        $product2->categories()->attach(5);

        $product2->sizes()->createMany([
            ['size' => 'S', 'stock' => 10],
            ['size' => 'M', 'stock' => 20],
            ['size' => 'L', 'stock' => 15],
            ['size' => 'XL', 'stock' => 10],
        ]);
    }
}