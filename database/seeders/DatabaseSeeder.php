<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            CategoriesSeeder::class,
        ]);

        $this->call([
            ProductsSeeder::class,
        ]);
        
        $this->call([
            UsersSeeder::class,
            AddressesSeeder::class,
        ]);
    }
}