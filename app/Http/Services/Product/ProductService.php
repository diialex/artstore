<?php

namespace App\Http\Services\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;



class ProductService
{
    public function getAll(): Collection
    {
        // Aquí puedes implementar la lógica para obtener todos los productos
        // Por ejemplo, podrías usar un modelo de Eloquent para recuperar los productos de la base de datos
     
        return Product::latest()->get(); // get() devuelve una Collection
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
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        // Aquí puedes implementar la lógica para actualizar un producto
        // Por ejemplo, podrías usar un modelo de Eloquent para actualizar el producto en la base de datos
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    {
        // Aquí puedes implementar la lógica para eliminar un producto
        // Por ejemplo, podrías usar un modelo de Eloquent para eliminar el producto de la base de datos
        $product->delete();
    }
}