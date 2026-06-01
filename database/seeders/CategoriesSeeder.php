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
            'name' => 'Crochet',
            'image' => 'storage/media/images/croche_gorro_estrella.jpeg'
        ]);

        Category::create([
            'name' => 'Mujer',
            'image' => 'storage/media/images/woman.png'
        ]);

        Category::create([
            'name' => 'Hombre',
            'image' => 'storage/media/images/man.png'
        ]);

        Category::create([
            'name' => 'Pantalones',
            'image' => 'storage/media/images/man.png'
        ]);

        Category::create([
            'name' => 'Camisetas',
            'image' => 'storage/media/images/camisa_hombre.jpeg'
        ]);

        Category::create([
            'name' => 'Accesorios',
            'image' => 'storage/media/images/maki_bolso.jpeg'
        ]);
    }
}
