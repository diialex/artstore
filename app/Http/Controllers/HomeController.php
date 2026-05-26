<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\RolesService;
use Database\Seeders\RolesSeeder;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use File;
use Cache;

class HomeController extends Controller
{
    public function __construct(protected ProductService $productService, protected CategoryService $categoryService)
    {
    }

    public function index(Request $request): View
    {
        $categoryId = $request->input('category');

        $products = Cache::rememberForever("products:all", fn() => $this->productService->getAll());

        $categories = Cache::rememberForever("categories:all", fn() => $this->categoryService->getAll());

        $carouselPath = storage_path('app/public/media/carrusel');
        $carouselImages = [];
        
        if (File::exists($carouselPath)) {
            $files = File::files($carouselPath);
            foreach ($files as $file) {
                $filename = $file->getBasename();
                if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $filename)) {
                    $carouselImages[] = 'storage/media/carrusel/' . $filename;
                }
            }
        }
        
        // Fallback si no hay imágenes
        if (empty($carouselImages)) {
            $carouselImages = [
                'storage/media/images/banner-example1.jpg',
                'storage/media/images/banner-example2.jpg',
                'storage/media/images/banner-example3.jpg',
                'storage/media/images/banner-example4.jpg',
            ];
        }

        return view('welcome', compact('categories', 'products', 'categoryId', 'carouselImages'));
    }
}
