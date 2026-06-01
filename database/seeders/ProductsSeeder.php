<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::all()->mapWithKeys(function ($cat) {
            return [$cat->getTranslation('name', 'es') => $cat->id];
        })->toArray();

        $products = [
            [
                'title' => [
                    'es' => 'Camiseta Térmica',
                    'en' => 'Thermal Shirt',
                    'fr' => 'Chemise Thermique',
                    'it' => 'Maglia Termica'
                ],
                'description' => [
                    'es' => 'Remera térmica cómoda y cálida, perfecta para cualquier ocasión.',
                    'en' => 'Comfortable and warm thermal shirt, perfect for any occasion.',
                    'fr' => 'T-shirt thermique confortable et chaud, parfait pour toute occasion.',
                    'it' => 'Maglia termica comoda e calda, perfetta per ogni occasione.'
                ],
                'price' => 45.00,
                'image_url' => 'storage/media/images/thermal shirt.jpeg',
                'categories' => ['Hombre', 'Camisetas'],
                'sizes' => [['size' => 'M', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Bolso Tote Spiderman',
                    'en' => 'Spiderman Tote Bag',
                    'fr' => 'Sac Fourre-tout Spiderman',
                    'it' => 'Borsa Tote Spiderman'
                ],
                'description' => [
                    'es' => 'Bolso tote con diseño de Spiderman, ideal para llevar tus cosas.',
                    'en' => 'Tote bag with Spiderman design, ideal for carrying your things.',
                    'fr' => 'Sac fourre-tout avec motif Spiderman, idéal pour transporter vos affaires.',
                    'it' => 'Borsa tote con design Spiderman, ideale per trasportare le tue cose.'
                ],
                'price' => 35.00,
                'image_url' => 'storage/media/images/tote_spiderman.jpeg',
                'categories' => ['Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Rebeca de Crochet',
                    'en' => 'Crochet Cardigan',
                    'fr' => 'Gilet en Crochet',
                    'it' => 'Cardigan all\'Uncinetto'
                ],
                'description' => [
                    'es' => 'Rebeca hecha a crochet, pieza única y artesanal.',
                    'en' => 'Crochet cardigan, a unique and handmade piece.',
                    'fr' => 'Gilet fait au crochet, pièce unique et artisanale.',
                    'it' => 'Cardigan fatto all\'uncinetto, pezzo unico e artigianale.'
                ],
                'price' => 55.00,
                'image_url' => 'storage/media/images/croche_rebeca.jpeg',
                'categories' => ['Crochet', 'Mujer'],
                'sizes' => [['size' => 'M', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Gorro Estrella Crochet',
                    'en' => 'Crochet Star Hat',
                    'fr' => 'Bonnet Étoile en Crochet',
                    'it' => 'Cappello Stella all\'Uncinetto'
                ],
                'description' => [
                    'es' => 'Gorro tejido a crochet con diseño de estrella, calentito y moderno.',
                    'en' => 'Crochet knitted hat with star design, warm and modern.',
                    'fr' => 'Bonnet tricoté au crochet avec motif étoile, chaud et moderne.',
                    'it' => 'Cappello lavorato all\'uncinetto con design a stella, caldo e moderno.'
                ],
                'price' => 28.00,
                'image_url' => 'storage/media/images/croche_gorro_estrella.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Jorts Pintados',
                    'en' => 'Painted Jorts',
                    'fr' => 'Jorts Peints',
                    'it' => 'Jorts Dipinti'
                ],
                'description' => [
                    'es' => 'Shorts de jean pintados a mano con diseños únicos y coloridos.',
                    'en' => 'Hand-painted denim shorts with unique and colorful designs.',
                    'fr' => 'Short en jean peint à la main avec des motifs uniques et colorés.',
                    'it' => 'Pantaloncini di jeans dipinti a mano con design unici e colorati.'
                ],
                'price' => 42.00,
                'image_url' => 'storage/media/images/painted jorts.jpeg',
                'categories' => ['Hombre', 'Pantalones'],
                'sizes' => [['size' => 'M', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Top Zapatero',
                    'en' => 'Zapatero Top',
                    'fr' => 'Haut Zapatero',
                    'it' => 'Top Zapatero'
                ],
                'description' => [
                    'es' => 'Top tejido artesanal, perfecto para un look casual chic.',
                    'en' => 'Hand-knitted top, perfect for a casual chic look.',
                    'fr' => 'Haut tricoté à la main, parfait pour un look décontracté chic.',
                    'it' => 'Top lavorato a mano, perfetto per un look casual chic.'
                ],
                'price' => 38.00,
                'image_url' => 'storage/media/images/top_zapatero.jpeg',
                'categories' => ['Crochet', 'Mujer'],
                'sizes' => [['size' => 'S', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Estrella Crochet Negro Azul',
                    'en' => 'Black Blue Crochet Star',
                    'fr' => 'Étoile Crochet Noir Bleu',
                    'it' => 'Stella Uncinetto Nero Blu'
                ],
                'description' => [
                    'es' => 'Pieza de crochet en colores negro y azul con diseño de estrella.',
                    'en' => 'Crochet piece in black and blue colors with a star design.',
                    'fr' => 'Pièce en crochet de couleurs noire et bleue avec motif étoile.',
                    'it' => 'Pezzo all\'uncinetto nei colori nero e blu con design a stella.'
                ],
                'price' => 32.00,
                'image_url' => 'storage/media/images/croche_estrella_negro_azul.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Top Crochet Celeste',
                    'en' => 'Light Blue Crochet Top',
                    'fr' => 'Haut Crochet Bleu Ciel',
                    'it' => 'Top Uncinetto Celeste'
                ],
                'description' => [
                    'es' => 'Top de crochet en tonos celestes, ligero y fresco.',
                    'en' => 'Crochet top in light blue tones, light and fresh.',
                    'fr' => 'Haut en crochet dans les tons bleu ciel, léger et frais.',
                    'it' => 'Top all\'uncinetto in tonalità celesti, leggero e fresco.'
                ],
                'price' => 40.00,
                'image_url' => 'storage/media/images/top_croche_celeste.jpeg',
                'categories' => ['Crochet', 'Mujer'],
                'sizes' => [['size' => 'S', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Bufanda Choso',
                    'en' => 'Choso Scarf',
                    'fr' => 'Écharpe Choso',
                    'it' => 'Sciarpa Choso'
                ],
                'description' => [
                    'es' => 'Bufanda tejida con estilo choso, cálida y acogedora.',
                    'en' => 'Knitted scarf with Choso style, warm and cozy.',
                    'fr' => 'Écharpe tricotée style Choso, chaude et douillette.',
                    'it' => 'Sciarpa lavorata a maglia in stile Choso, calda e accogliente.'
                ],
                'price' => 30.00,
                'image_url' => 'storage/media/images/bufanda_choso.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Bolso Maki',
                    'en' => 'Maki Bag',
                    'fr' => 'Sac Maki',
                    'it' => 'Borsa Maki'
                ],
                'description' => [
                    'es' => 'Bolso decorativo con inspiración en maki sushi, arte textil.',
                    'en' => 'Decorative bag inspired by maki sushi, textile art.',
                    'fr' => 'Sac décoratif inspiré du maki sushi, art textile.',
                    'it' => 'Borsa decorativa ispirata al maki sushi, arte tessile.'
                ],
                'price' => 38.00,
                'image_url' => 'storage/media/images/maki_bolso.jpeg',
                'categories' => ['Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Estrella de Crochet',
                    'en' => 'Crochet Star',
                    'fr' => 'Étoile en Crochet',
                    'it' => 'Stella all\'Uncinetto'
                ],
                'description' => [
                    'es' => 'Accesorio de crochet con forma de estrella, pieza decorativa.',
                    'en' => 'Crochet accessory in the shape of a star, decorative piece.',
                    'fr' => 'Accessoire en crochet en forme d\'étoile, pièce décorative.',
                    'it' => 'Accessorio all\'uncinetto a forma di stella, pezzo decorativo.'
                ],
                'price' => 25.00,
                'image_url' => 'storage/media/images/croche_estrella.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 2]],
            ],
            [
                'title' => [
                    'es' => 'Bolsito Flor Crochet',
                    'en' => 'Crochet Flower Bag',
                    'fr' => 'Petit Sac Fleur Crochet',
                    'it' => 'Borsetta Fiore Uncinetto'
                ],
                'description' => [
                    'es' => 'Pequeño bolsito decorado con flores de crochet tejidas.',
                    'en' => 'Small bag decorated with knitted crochet flowers.',
                    'fr' => 'Petit sac décoré de fleurs tricotées au crochet.',
                    'it' => 'Piccola borsa decorata con fiori all\'uncinetto lavorati a maglia.'
                ],
                'price' => 32.00,
                'image_url' => 'storage/media/images/flor_crochet_bolsito.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Tote Crochet Orquídea',
                    'en' => 'Orchid Crochet Tote',
                    'fr' => 'Tote Crochet Orchidée',
                    'it' => 'Tote Uncinetto Orchidea'
                ],
                'description' => [
                    'es' => 'Bolso tote con motivos florales de orquídea en crochet.',
                    'en' => 'Tote bag with orchid floral motifs in crochet.',
                    'fr' => 'Sac fourre-tout avec motifs floraux d\'orchidée en crochet.',
                    'it' => 'Borsa tote con motivi floreali di orchidea all\'uncinetto.'
                ],
                'price' => 50.00,
                'image_url' => 'storage/media/images/tote_croche_orquidea.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Bolsito Estrella Crochet',
                    'en' => 'Crochet Star Bag',
                    'fr' => 'Petit Sac Étoile Crochet',
                    'it' => 'Borsetta Stella Uncinetto'
                ],
                'description' => [
                    'es' => 'Bolsito pequeño tejido con patrón de estrellas.',
                    'en' => 'Small woven bag with a star pattern.',
                    'fr' => 'Petit sac tissé avec un motif d\'étoiles.',
                    'it' => 'Piccola borsa intrecciata con motivo a stelle.'
                ],
                'price' => 28.00,
                'image_url' => 'storage/media/images/bolsito_estrella_croche.jpeg',
                'categories' => ['Crochet', 'Accesorios'],
                'sizes' => [['size' => 'Único', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Top Tirantes con Botones',
                    'en' => 'Button Strap Top',
                    'fr' => 'Haut à Bretelles Boutons',
                    'it' => 'Top con Spalline e Bottoni'
                ],
                'description' => [
                    'es' => 'Top con tirantes y detalles de botones, estilo casual elegante.',
                    'en' => 'Top with straps and button details, casual elegant style.',
                    'fr' => 'Haut à bretelles avec détails de boutons, style décontracté chic.',
                    'it' => 'Top con spalline e dettagli di bottoni, stile casual elegante.'
                ],
                'price' => 36.00,
                'image_url' => 'storage/media/images/top_tirantes_botones.jpeg',
                'categories' => ['Mujer', 'Camisetas'],
                'sizes' => [['size' => 'S', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Top Estrella Crochet',
                    'en' => 'Crochet Star Top',
                    'fr' => 'Haut Étoile Crochet',
                    'it' => 'Top Stella Uncinetto'
                ],
                'description' => [
                    'es' => 'Top de crochet con motivos de estrellas, fresco y moderno.',
                    'en' => 'Crochet top with star motifs, fresh and modern.',
                    'fr' => 'Haut en crochet avec motifs d\'étoiles, frais et moderne.',
                    'it' => 'Top all\'uncinetto con motivi a stella, fresco e moderno.'
                ],
                'price' => 41.00,
                'image_url' => 'storage/media/images/estrella_chochet_top.jpeg',
                'categories' => ['Crochet', 'Mujer'],
                'sizes' => [['size' => 'M', 'stock' => 1]],
            ],
            [
                'title' => [
                    'es' => 'Jorts Tigre',
                    'en' => 'Tiger Jorts',
                    'fr' => 'Jorts Tigre',
                    'it' => 'Jorts Tigre'
                ],
                'description' => [
                    'es' => 'Shorts de jean con estampado de tigre, audaz y colorido.',
                    'en' => 'Denim shorts with tiger print, bold and colorful.',
                    'fr' => 'Short en jean avec imprimé tigre, audacieux et coloré.',
                    'it' => 'Pantaloncini di jeans con stampa a tigre, audaci e colorati.'
                ],
                'price' => 43.00,
                'image_url' => 'storage/media/images/jorts_tiger.jpeg',
                'categories' => ['Hombre', 'Pantalones'],
                'sizes' => [['size' => 'M', 'stock' => 1]],
            ],
        ];

        foreach ($products as $data) {

            $product = Product::updateOrCreate(
                ['image_url' => $data['image_url']],
                collect($data)->except(['categories', 'sizes', 'image_url'])->all()
            );

            $product->categories()->sync(
                collect($data['categories'])->map(fn ($name) => $categoryIds[$name] ?? null)->filter()->all()
            );

            $product->sizes()->delete();
            $product->sizes()->createMany($data['sizes']);
        }
    }
}