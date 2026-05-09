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
    // CAMBIO: De belongsTo a hasMany
    return $this->hasMany(Size::class, 'product_id'); 
    }

    public function getTotalStockAttribute(): int
    {
        // Ahora que es hasMany, sizes devolverá una Colección (o vacía), 
        // permitiendo que sum() funcione correctamente.
        return $this->sizes ? $this->sizes->sum('stock') : 0;
    }
}
