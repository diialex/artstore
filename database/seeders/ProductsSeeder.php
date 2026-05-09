<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {

        $tallas=[Size::create([
            'talla'=>'S',
            'stock'=>'10'
        ]),
        Size::create([
            'talla'=>'M',
            'stock'=>'20'
        ]),
        Size::create([
            'talla'=>'L',
            'stock'=>'15'
        ]),
        Size::create([
            'talla'=>'XL',
            'stock'=>'10'
        ])];

        $product=Product::create([
            'title' => 'Jordan 1 Retro High OG "Chicago"',
            'description' => 'Zapatillas de baloncesto icónicas con diseño retro y tecnología de puntera.',
            'price' => 150.00,
            'stock' => 10,
            'image_url' => 'https://example.com/images/jordan-1-chicago.jpg'
        ]);

        foreach($tallas as $talla){
            $product->sizes()->associate($talla);
        }

        $product=Product::create([
            'title' => 'Converse Chuck Taylor All Star',
            'description' => 'Zapatillas clásicas y versátiles, ideales para cualquier estilo de vida.',
            'price' => 120.00,
            'stock' => 15,
            'image_url' => 'https://example.com/images/converse-chuck-taylor.jpg'
        ]);


        foreach($tallas as $talla){
            $product->sizes()->associate($talla);
        }
    }
}