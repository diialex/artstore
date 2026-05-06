<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::create([
            'user_id' => 1,
            'street' => 'Calle Principal 123',
            'city' => 'Madrid',
            'zip_code' => '28001'
        ]);

        Address::create([
            'user_id' => 2,
            'street' => 'Avenida de la Artesanía 45',
            'city' => 'Sevilla',
            'zip_code' => '41001'
        ]);

        Address::create([
            'user_id' => 3,
            'street' => 'Calle Castillo de la guarda 27',
            'city' => 'Sevilla',
            'zip_code' => '41006'
        ]);
        
        
    }
}