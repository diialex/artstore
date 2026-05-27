<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Thermal Shirt
        $product = Product::create([
            'title' => 'Thermal Shirt',
            'description' => 'Remera térmica cómoda y cálida, perfecta para cualquier ocasión.',
            'price' => 45.00,
            'image_url' => 'storage/media/images/thermal shirt.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'M', 'stock' => 1],
        ]);

        // Tote Spiderman
        $product = Product::create([
            'title' => 'Tote Spiderman',
            'description' => 'Bolso tote con diseño de Spiderman, ideal para llevar tus cosas.',
            'price' => 35.00,
            'image_url' => 'storage/media/images/tote_spiderman.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'Único', 'stock' => 1],
        ]);

        // Crochet Rebeca
        $product = Product::create([
            'title' => 'Crochet Rebeca',
            'description' => 'Rebeca hecha a crochet, pieza única y artesanal.',
            'price' => 55.00,
            'image_url' => 'storage/media/images/croche_rebeca.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'M', 'stock' => 1],
        ]);

        // Crochet Gorro Estrella
        $product = Product::create([
            'title' => 'Crochet Gorro Estrella',
            'description' => 'Gorro tejido a crochet con diseño de estrella, calentito y moderno.',
            'price' => 28.00,
            'image_url' => 'storage/media/images/croche_gorro_estrella.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'Único', 'stock' => 1],
        ]);

        // Painted Jorts
        $product = Product::create([
            'title' => 'Painted Jorts',
            'description' => 'Shorts de jean pintados a mano con diseños únicos y coloridos.',
            'price' => 42.00,
            'image_url' => 'storage/media/images/painted jorts.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'M', 'stock' => 1],
        ]);

        // Top Zapatero
        $product = Product::create([
            'title' => 'Top Zapatero',
            'description' => 'Top tejido artesanal, perfecto para un look casual chic.',
            'price' => 38.00,
            'image_url' => 'storage/media/images/top_zapatero.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'S', 'stock' => 1],
        ]);


        // Crochet Estrella Negro Azul
        $product = Product::create([
            'title' => 'Crochet Estrella Negro Azul',
            'description' => 'Pieza de crochet en colores negro y azul con diseño de estrella.',
            'price' => 32.00,
            'image_url' => 'storage/media/images/croche_estrella_negro_azul.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'Único', 'stock' => 1],
        ]);

        // Top Crochet Celeste
        $product = Product::create([
            'title' => 'Top Crochet Celeste',
            'description' => 'Top de crochet en tonos celestes, ligero y fresco.',
            'price' => 40.00,
            'image_url' => 'storage/media/images/top_croche_celeste.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'S', 'stock' => 1],
        ]);

        // Bufanda Choso
        $product = Product::create([
            'title' => 'Bufanda Choso',
            'description' => 'Bufanda tejida con estilo choso, cálida y acogedora.',
            'price' => 30.00,
            'image_url' => 'storage/media/images/bufanda_choso.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'Único', 'stock' => 1],
        ]);

        // Maki Bolso
        $product = Product::create([
            'title' => 'Maki Bolso',
            'description' => 'Bolso decorativo con inspiración en maki sushi, arte textil.',
            'price' => 38.00,
            'image_url' => 'storage/media/images/maki_bolso.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'Único', 'stock' => 1],
        ]);

        // Crochet Estrella
        $product = Product::create([
            'title' => 'Crochet Estrella',
            'description' => 'Accesorio de crochet con forma de estrella, pieza decorativa.',
            'price' => 25.00,
            'image_url' => 'storage/media/images/croche_estrella.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'Único', 'stock' => 2],
        ]);

        // Flor Crochet Bolsito
        $product = Product::create([
            'title' => 'Flor Crochet Bolsito',
            'description' => 'Pequeño bolsito decorado con flores de crochet tejidas.',
            'price' => 32.00,
            'image_url' => 'storage/media/images/flor_crochet_bolsito.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'Único', 'stock' => 1],
        ]);

        // Tote Crochet Orquídea
        $product = Product::create([
            'title' => 'Tote Crochet Orquídea',
            'description' => 'Bolso tote con motivos florales de orquídea en crochet.',
            'price' => 50.00,
            'image_url' => 'storage/media/images/tote_croche_orquidea.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'Único', 'stock' => 1],
        ]);

        // Bolsito Estrella Crochet
        $product = Product::create([
            'title' => 'Bolsito Estrella Crochet',
            'description' => 'Bolsito pequeño tejido con patrón de estrellas.',
            'price' => 28.00,
            'image_url' => 'storage/media/images/bolsito_estrella_croche.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'Único', 'stock' => 1],
        ]);

        // Top Tirantes Botones
        $product = Product::create([
            'title' => 'Top Tirantes Botones',
            'description' => 'Top con tirantes y detalles de botones, estilo casual elegante.',
            'price' => 36.00,
            'image_url' => 'storage/media/images/top_tirantes_botones.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'S', 'stock' => 1],
        ]);

        // Estrella Crochet Top
        $product = Product::create([
            'title' => 'Estrella Crochet Top',
            'description' => 'Top de crochet con motivos de estrellas, fresco y moderno.',
            'price' => 41.00,
            'image_url' => 'storage/media/images/estrella_chochet_top.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'M', 'stock' => 1],
        ]);

        // Jorts Tiger
        $product = Product::create([
            'title' => 'Jorts Tiger',
            'description' => 'Shorts de jean con estampado de tigre, audaz y colorido.',
            'price' => 43.00,
            'image_url' => 'storage/media/images/jorts_tiger.jpeg'
        ]);
        $product->categories()->attach(1);
        $product->sizes()->createMany([
            ['size' => 'M', 'stock' => 1],
        ]);
    }
}