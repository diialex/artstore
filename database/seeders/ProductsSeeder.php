<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $datosTallas = [
            ['size' => 'S', 'stock' => 10],
            ['size' => 'M', 'stock' => 20],
            ['size' => 'L', 'stock' => 15],
            ['size' => 'XL', 'stock' => 10],
        ];

        $product_1 = Product::create([
            'title' => 'Jordan 1 Retro High OG "Chicago"',
            'description' => 'Zapatillas de baloncesto icónicas con diseño retro y tecnología de puntera.',
            'price' => 150.00,
            'stock' => 10,
            'image_url' => 'storage/app/public/media/images/air-jordan-1-high-unc-toe-release.png'
        ]);
        
        $product_1->categories()->attach([2, 3, 4]);
        $product_1->sizes()->createMany($datosTallas); 
        

        $product_2 = Product::create([
            'title' => 'Converse Chuck Taylor All Star',
            'description' => 'Zapatillas clásicas y versátiles, ideales para cualquier estilo de vida.',
            'price' => 120.00,
            'stock' => 15,
            'image_url' => 'storage/app/public/media/images/daRealConverse.png'
        ]);

        $product_2->categories()->attach([1, 5]);
        $product_2->sizes()->createMany($datosTallas);
    }
}