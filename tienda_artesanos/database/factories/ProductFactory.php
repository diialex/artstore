<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 200), // Precios entre 10€ y 200€
            'stock' => fake()->numberBetween(1, 50),
            // Usamos un servicio gratuito para generar imágenes de prueba (!!!)
            'image' => 'https://picsum.photos/seed/' . fake()->uuid() . '/400/300',
        ];
    }
}
