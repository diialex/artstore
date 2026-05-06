<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'description', 'price', 'stock', 'image_url'];

    // Relación N:M con Categorías
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Relación 1:N con Tallas
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    // Esto te permite llamar a $product->total_stock en cualquier parte del código
    public function getTotalStockAttribute(): int
    {
        // Suma la columna 'stock' de todas las tallas relacionadas
        return $this->sizes->sum('stock');
    }
}
