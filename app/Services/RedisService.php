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
        return Cache::rememberForever(RedisConstants::CATEGORIES_ALL, fn() => app(CategoryService::class)->getAll());
    }

    public static function flushCategories(){
        Cache::forget(RedisConstants::CATEGORIES_ALL);
    }

    public static function getProducts($sort = null){
        $sort = self::normalizeProductSort($sort);

        return Cache::rememberForever(
            RedisConstants::PRODUCTS_ALL . ':' . ($sort ?? 'default'),
            fn() => app(ProductService::class)->getAll(null, $sort)
        );
    }

    public static function flushProducts(){
        Cache::forget(RedisConstants::PRODUCTS_ALL);
    }

    public static function getProductsByCategory($categories, $sort = null){
        $categories = collect((array) $categories)
            ->filter()
            ->map(fn ($categoryId) => (int) $categoryId)
            ->unique()
            ->sort()
            ->values()
            ->all();
        $sort = self::normalizeProductSort($sort);

        return Cache::remember(
            RedisConstants::PRODUCTS_BY_CATEGORY . implode('-', $categories) . ':' . ($sort ?? 'default'),
            3600,
            fn() => app(ProductService::class)->getAll($categories, $sort)
        );
    }

    private static function normalizeProductSort($sort): ?string
    {
        return in_array($sort, ['price_asc', 'price_desc', 'newest', 'oldest'], true) ? $sort : null;
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
