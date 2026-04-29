<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */

    public function run(): void
    {
       
        
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,      
            // CategoriesSeeder::class, 
            ProductsSeeder::class,   
            
        ]);
    }
}