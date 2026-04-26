<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function create(array $data)
    {
        return Category::create($data);
    }

    public function getAll(): Collection 
    {
        // Ordenamos por las más recientes y paginamos
        return Category::all();
    }

    public function update(Category $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category)
    {
        $category->delete();
    }
}