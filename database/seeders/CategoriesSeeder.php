<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => [
                'es' => 'Crochet',
                'en' => 'Crochet',
                'fr' => 'Crochet',
                'it' => 'Uncinetto'
            ],
            'image' => 'storage/media/images/croche_gorro_estrella.jpeg'
        ]);

        Category::create([
            'name' => [
                'es' => 'Mujer',
                'en' => 'Woman',
                'fr' => 'Femme',
                'it' => 'Donna'
            ],
            'image' => 'storage/media/images/woman.png'
        ]);

        Category::create([
            'name' => [
                'es' => 'Hombre',
                'en' => 'Man',
                'fr' => 'Homme',
                'it' => 'Uomo'
            ],
            'image' => 'storage/media/images/man.png'
        ]);

        Category::create([
            'name' => [
                'es' => 'Pantalones',
                'en' => 'Pants',
                'fr' => 'Pantalons',
                'it' => 'Pantaloni'
            ],
            'image' => 'storage/media/images/man.png' // Ojo: tienes la misma imagen que hombre
        ]);

        Category::create([
            'name' => [
                'es' => 'Camisetas',
                'en' => 'T-shirts',
                'fr' => 'T-shirts',
                'it' => 'Magliette'
            ],
            'image' => 'storage/media/images/camisa_hombre.jpeg'
        ]);

        Category::create([
            'name' => [
                'es' => 'Accesorios',
                'en' => 'Accessories',
                'fr' => 'Accessoires',
                'it' => 'Accessori'
            ],
            'image' => 'storage/media/images/maki_bolso.jpeg'
        ]);
    }
}