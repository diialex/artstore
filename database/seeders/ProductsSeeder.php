<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id', 'name');

        $products = [
            [
                'title' => 'Thermal Shirt',
                'description' => 'Remera térmica cómoda y cálida, perfecta para cualquier ocasión.',
                'price' => 45.00,
                'image_url' => 'storage/media/images/thermal shirt.jpeg',
                'categories' => ['Hombre', 'Camisetas'],
                'sizes' => [['size' => 'M', 'stock' => 1]],
            ],
            [
                'title' => 'Tote Spiderman',
                'description' => 'Bolso tote con diseño de Spiderman, ideal para llevar tus cosas.',
                'price' => 35.00,
                'image_url' => 'storage/media/images/tote_spiderman.jpeg',
                'categories' => ['Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => 'Crochet Rebeca',
                'description' => 'Rebeca hecha a crochet, pieza única y artesanal.',
                'price' => 55.00,
                'image_url' => 'storage/media/images/croche_rebeca.jpeg',
                'categories' => ['Crochet', 'Mujer'],
                'sizes' => [['size' => 'M', 'stock' => 1]],
            ],
            [
                'title' => 'Crochet Gorro Estrella',
                'description' => 'Gorro tejido a crochet con diseño de estrella, calentito y moderno.',
                'price' => 28.00,
                'image_url' => 'storage/media/images/croche_gorro_estrella.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => 'Painted Jorts',
                'description' => 'Shorts de jean pintados a mano con diseños únicos y coloridos.',
                'price' => 42.00,
                'image_url' => 'storage/media/images/painted jorts.jpeg',
                'categories' => ['Hombre', 'Pantalones'],
                'sizes' => [['size' => 'M', 'stock' => 1]],
            ],
            [
                'title' => 'Top Zapatero',
                'description' => 'Top tejido artesanal, perfecto para un look casual chic.',
                'price' => 38.00,
                'image_url' => 'storage/media/images/top_zapatero.jpeg',
                'categories' => ['Crochet', 'Mujer'],
                'sizes' => [['size' => 'S', 'stock' => 1]],
            ],
            [
                'title' => 'Crochet Estrella Negro Azul',
                'description' => 'Pieza de crochet en colores negro y azul con diseño de estrella.',
                'price' => 32.00,
                'image_url' => 'storage/media/images/croche_estrella_negro_azul.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => 'Top Crochet Celeste',
                'description' => 'Top de crochet en tonos celestes, ligero y fresco.',
                'price' => 40.00,
                'image_url' => 'storage/media/images/top_croche_celeste.jpeg',
                'categories' => ['Crochet', 'Mujer'],
                'sizes' => [['size' => 'S', 'stock' => 1]],
            ],
            [
                'title' => 'Bufanda Choso',
                'description' => 'Bufanda tejida con estilo choso, cálida y acogedora.',
                'price' => 30.00,
                'image_url' => 'storage/media/images/bufanda_choso.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => 'Maki Bolso',
                'description' => 'Bolso decorativo con inspiración en maki sushi, arte textil.',
                'price' => 38.00,
                'image_url' => 'storage/media/images/maki_bolso.jpeg',
                'categories' => ['Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => 'Crochet Estrella',
                'description' => 'Accesorio de crochet con forma de estrella, pieza decorativa.',
                'price' => 25.00,
                'image_url' => 'storage/media/images/croche_estrella.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 2]],
            ],
            [
                'title' => 'Flor Crochet Bolsito',
                'description' => 'Pequeño bolsito decorado con flores de crochet tejidas.',
                'price' => 32.00,
                'image_url' => 'storage/media/images/flor_crochet_bolsito.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => 'Tote Crochet Orquídea',
                'description' => 'Bolso tote con motivos florales de orquídea en crochet.',
                'price' => 50.00,
                'image_url' => 'storage/media/images/tote_croche_orquidea.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => 'Bolsito Estrella Crochet',
                'description' => 'Bolsito pequeño tejido con patrón de estrellas.',
                'price' => 28.00,
                'image_url' => 'storage/media/images/bolsito_estrella_croche.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => 'Top Tirantes Botones',
                'description' => 'Top con tirantes y detalles de botones, estilo casual elegante.',
                'price' => 36.00,
                'image_url' => 'storage/media/images/top_tirantes_botones.jpeg',
                'categories' => ['Mujer', 'Camisetas'],
                'sizes' => [['size' => 'S', 'stock' => 1]],
            ],
            [
                'title' => 'Estrella Crochet Top',
                'description' => 'Top de crochet con motivos de estrellas, fresco y moderno.',
                'price' => 41.00,
                'image_url' => 'storage/media/images/estrella_chochet_top.jpeg',
                'categories' => ['Crochet', 'Mujer'],
                'sizes' => [['size' => 'M', 'stock' => 1]],
            ],
            [
                'title' => 'Jorts Tiger',
                'description' => 'Shorts de jean con estampado de tigre, audaz y colorido.',
                'price' => 43.00,
                'image_url' => 'storage/media/images/jorts_tiger.jpeg',
                'categories' => ['Hombre', 'Pantalones'],
                'sizes' => [['size' => 'M', 'stock' => 1]],
            ],
        ];

        foreach ($products as $data) {
            $product = Product::updateOrCreate(
                ['title' => $data['title']],
                collect($data)->except(['categories', 'sizes'])->all()
            );

            $product->categories()->sync(
                collect($data['categories'])->map(fn ($name) => $categoryIds[$name])->all()
            );

            $product->sizes()->delete();
            $product->sizes()->createMany($data['sizes']);
        }
    }
}
