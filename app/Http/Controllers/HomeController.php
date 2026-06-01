<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\GuestCartService;
use App\Services\RedisService;
use App\Services\RolesService;
use Database\Seeders\RolesSeeder;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use File;
use Cache;
use App\Constants\RedisConstants;

class HomeController extends Controller
{
    public function __construct(protected ProductService $productService, protected CategoryService $categoryService)
    {
    }

    public function index(Request $request): View
    {
        $selectedCategoryIds = collect((array) $request->input('categories', []))
            ->when($request->input('category'), fn ($ids) => $ids->push($request->input('category')))
            ->filter()
            ->map(fn ($categoryId) => (int) $categoryId)
            ->unique()
            ->values()
            ->all();

        $categoryId = $selectedCategoryIds[0] ?? null;
        $isCatalogView = !empty($selectedCategoryIds) || $request->boolean('catalog');
        $sort = in_array($request->input('sort'), ['price_asc', 'price_desc', 'newest', 'oldest'], true)
            ? $request->input('sort')
            : null;

        // Filtrar productos por categoría si existe, sino obtener todos
        $products = !empty($selectedCategoryIds)
            ? RedisService::getProductsByCategory($selectedCategoryIds, $sort)
            : RedisService::getProducts($sort);

        $categories = RedisService::getCategories();

        $carouselPath = public_path('storage/media/carrusel');
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

        return view('welcome', compact('categories', 'products', 'categoryId', 'selectedCategoryIds', 'isCatalogView', 'sort', 'carouselImages'));
    }
}
