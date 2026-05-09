<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function getAll($categoryId = null): Collection
    {
        $query = Product::query();

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId); 
            });
        }

        return $query->get();
    }

    public function getById(int $id): ?Product
    {
        return Product::findOrFail($id);
    }

    public function create(array $data): Product
    {
        if (isset($data['image_url'])) {
            $path = $data['image_url']->store('media/imgProd', 'public');
            $data['image_url'] = $path;
        }

        $product = Product::create($data);

        if (isset($data['categories'])) {
            $product->categories()->attach($data['categories']);
        }
        
        if (isset($data['sizes'])) {
            $isUserAdmin = auth()->check() && auth()->user()->role_id == 1; // Ajustado por si acaso
            
            foreach ($data['sizes'] as $sizeData) {
                if (!empty($sizeData['name'])) { 
                    $product->sizes()->create([
                        'size' => $sizeData['name'],
                        'stock' => $sizeData['stock'],
                    ]);
                }
            }
        }

        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        
        if (isset($data['categories'])) {
            $product->categories()->sync($data['categories']);
        } else {
            $product->categories()->detach();
        }
        
        if (isset($data['sizes'])) {
            $product->sizes()->delete(); 
            $isUserAdmin = auth()->check() && auth()->user()->role_id == 1; 

            foreach ($data['sizes'] as $sizeData) {
                if (!empty($sizeData['name'])) {
                    $product->sizes()->create([
                        'size' => $sizeData['name'],
                        'stock' => $sizeData['stock'],
                        'is_approved' => $isUserAdmin
                    ]);
                }
            }
        } else {
            $product->sizes()->delete();
        }
        
        return $product;
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}