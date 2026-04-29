<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {

        Product::create([
            'name' => 'Cuadro "El Grito" de Edvard Munch',
            'description' => 'Una reproducción del famoso cuadro "El Grito" de Edvard Munch, que captura la angustia y la desesperación humana.',
            'price' => 150.00,
            'image' => 'https://example.com/images/el-grito.jpg'
        ]);

        Product::create([
            'name' => 'Cuadro "La Noche Estrellada" de Vincent van Gogh',
            'description' => 'Una reproducción del icónico cuadro "La Noche Estrellada" de Vincent van Gogh, que muestra un cielo nocturno lleno de estrellas y un pueblo tranquilo.',
            'price' => 200.00,
            'image' => 'https://example.com/images/la-noche-estrellada.jpg'
        ]);

        
    }
}