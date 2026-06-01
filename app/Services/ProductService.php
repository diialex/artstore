<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class ProductService
{
    public function getAll($categoryIds = null, ?string $sort = null): Collection
    {
        $query = Product::query();
        $categoryIds = collect((array) $categoryIds)
            ->filter()
            ->map(fn ($categoryId) => (int) $categoryId)
            ->unique()
            ->values();

        foreach ($categoryIds as $categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'newest' => $query->orderByDesc('created_at'),
            'oldest' => $query->orderBy('created_at'),
            default => null,
        };

        return $query->get();
    }

    public function getById(int $id): ?Product
    {
        return Product::findOrFail($id);
    }

    public function create(array $data): Product
    {
        if (isset($data['image_url']) && $data['image_url'] instanceof UploadedFile) {
            $data['image_url'] = $this->storeImage($data['image_url']);
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
        if (isset($data['image_url']) && $data['image_url'] instanceof UploadedFile) {
            $data['image_url'] = $this->storeImage($data['image_url']);
        } else {
            // Sin imagen nueva: conservamos la actual.
            unset($data['image_url']);
        }

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

    /**
     * Guarda la imagen subida en public/storage/media/imgProd y devuelve
     * la ruta relativa ('storage/media/imgProd/...') que usan las vistas con asset().
     */
    private function storeImage(UploadedFile $file): string
    {
        $dir = public_path('storage/media/imgProd');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $filename = uniqid('prod_', true) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);

        return 'storage/media/imgProd/' . $filename;
    }
}
