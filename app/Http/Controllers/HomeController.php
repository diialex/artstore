<?php

namespace App\Http\Controllers;

use App\Services\RolesService;
use Database\Seeders\RolesSeeder;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(): View
    {

        $categories = Category::all(); // Obtener todas las categorías para mostrar en la vista
        $products = Product::all();

        return view('welcome', ['categories' => $categories, 'products' => $products]);
    }
}
