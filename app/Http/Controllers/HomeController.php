<?php

namespace App\Http\Controllers;

use App\Services\RolesService;
use Database\Seeders\RolesSeeder;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;

class HomeController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    public function index(Request $request): View
    {
        // 1. Miramos si el usuario ha hecho clic en alguna categoría
        $categoryId = $request->input('category');

        // 2. Usamos tu servicio que ya sabe cómo buscar en relaciones N:N
        $products = $this->productService->getAll($categoryId);

        // 3. Mandamos los datos a la vista
        $categories = Category::all();

        return view('welcome', compact('categories', 'products', 'categoryId'));
    }
}
