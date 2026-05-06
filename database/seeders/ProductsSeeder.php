<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {

        Product::create([
            'title' => 'Jordan 1 Retro High OG "Chicago"',
            'description' => 'Zapatillas de baloncesto icónicas con diseño retro y tecnología de puntera.',
            'price' => 150.00,
            'stock' => 10,
            'image_url' => 'https://example.com/images/jordan-1-chicago.jpg'
        ]);

        Product::create([
            'title' => 'Converse Chuck Taylor All Star',
            'description' => 'Zapatillas clásicas y versátiles, ideales para cualquier estilo de vida.',
            'price' => 120.00,
            'stock' => 15,
            'image_url' => 'https://example.com/images/converse-chuck-taylor.jpg'
        ]);
    }
}