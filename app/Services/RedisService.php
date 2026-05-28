<?php

namespace App\Services;
use App\Constants\RedisConstants;
use Illuminate\Database\Eloquent\Collection;
use Cache;
use Illuminate\Support\Facades\Redis;

class RedisService
{
    public function __construct(protected ProductService $productService, protected CategoryService $categoryService){
    }
    public static function getCategories(){
        return Cache::rememberForever(RedisConstants::CATEGORIES_ALL, fn() => $this->categoryService->getAll());
    }

    public static function flushCategories(){
        Cache::forget(RedisConstants::CATEGORIES_ALL);
    }

    public static function getProducts(){
        return Cache::rememberForever(RedisConstants::PRODUCTS_ALL, fn() => $this->productService->getAll());
    }

    public static function flushProducts(){
        Cache::forget(RedisConstants::PRODUCTS_ALL);
    }

    public static function getProductsByCategory($category){
        return Cache::remember(RedisConstants::PRODUCTS_BY_CATEGORY . $category, 3600, fn() => $this->productService->getAll($category));
    }

    public static function flushProductsByCategory(){
        $keys = Redis::keys('products:*');

        if (!empty($keys)) {
            // Si tienes prefijo configurado en config/database.php, hay que quitarlo
            $prefix = config('database.redis.options.prefix', '');
            $keys = array_map(fn($key) => str_replace($prefix, '', $key), $keys);
            
            Redis::del($keys);
        }
    }


}