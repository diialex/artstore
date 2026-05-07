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
            $imgUrl= $data['image_url'];
            $dataImg= ('public\media\imgProd'+ $imgUrl);
            $data['image'] = $dataImg;
            $product = Product::create($data);

        }

        $product = Product::create($data);

        if (isset($data['categories'])) {
            $product->categories()->attach($data['categories']);
        }

        
        if (isset($data['sizes'])) {
            $isUserAdmin = auth()->check() && auth()->user()->hasRol('Admin');
            
            foreach ($data['sizes'] as $sizeData) {
                if (!empty($sizeData['name'])) { 
                    $product->sizes()->create([
                        'size' => $sizeData['name'],
                        'stock' => $sizeData['stock'],
                        'is_approved' => $isUserAdmin
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
            $isUserAdmin = auth()->check() && auth()->user()->hasRol('Admin');

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