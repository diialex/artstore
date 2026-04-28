<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {

        Product::create([
            'title' => 'Cuadro "El Grito" de Edvard Munch',
            'description' => 'Una reproducción del famoso cuadro "El Grito" de Edvard Munch, que captura la angustia y la desesperación humana.',
            'price' => 150.00,
            'stock' => 10,
            'image_url' => 'https://example.com/images/el-grito.jpg'
        ]);

        Product::create([
            'title' => 'Cuadro "La Noche Estrellada" de Vincent van Gogh',
            'description' => 'Una reproducción del icónico cuadro "La Noche Estrellada" de Vincent van Gogh, que muestra un cielo nocturno lleno de estrellas y un pueblo tranquilo.',
            'price' => 200.00,
            'stock' => 5,
            'image_url' => 'https://example.com/images/la-noche-estrellada.jpg'
        ]);
    }
}