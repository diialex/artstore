<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;



class ProductService
{
    public function getAll($categoryId = null): Collection
    {
        // Empezamos a construir la consulta (sin ejecutarla todavía)
        $query = Product::query();

        // Si nos pasan una categoría por la URL, aplicamos el filtro mágico
        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId); // Ojo con especificar 'categories.id'
            });
        }

        // Ejecutamos la consulta y devolvemos los productos
        return $query->get();
    }

    public function getById(int $id): ?Product
    {
        // Aquí puedes implementar la lógica para obtener un producto por su ID
        // Por ejemplo, podrías usar un modelo de Eloquent para recuperar el producto de la base de datos
        return Product::findOrFail($id);
    }

    public function create(array $data): Product
    {
        // Aquí puedes implementar la lógica para crear un producto
        // Por ejemplo, podrías usar un modelo de Eloquent para guardar el producto en la base de datos
        $product = Product::create($data);

        // 2. Si nos han enviado categorías, las enganchamos (attach)
        if (isset($data['categories'])) {
            $product->categories()->attach($data['categories']);
        }

        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        // Aquí puedes implementar la lógica para actualizar un producto
        // Por ejemplo, podrías usar un modelo de Eloquent para actualizar el producto en la base de datos
        $product->update($data);
        
        //Sincronizamos las casillas marcadas (borra las desmarcadas y añade las nuevas)
        if (isset($data['categories'])) {
            $product->categories()->sync($data['categories']);
        } else {
            // Si no hay ninguna marcada, desvinculamos todas
            $product->categories()->detach();
        }
        
        
        return $product;
    }

    public function delete(Product $product)
    {
        // Aquí puedes implementar la lógica para eliminar un producto
        // Por ejemplo, podrías usar un modelo de Eloquent para eliminar el producto de la base de datos
        $product->delete();
    }
}