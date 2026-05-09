<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'stock', 'image_url'];
    
    protected $hidden = [
        'id',
    ];
    // Relación N:M con Categorías
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación 1:N con Tallas
    public function sizes()
    {
        return $this->belongsTo(Size::class);
    }

    // Esto te permite llamar a $product->total_stock en cualquier parte del código
    public function getTotalStockAttribute(): int
{
    // Si $this->sizes es null, devuelve 0. 
    // Si no es null, ejecuta el sum.
    return $this->sizes ? $this->sizes->sum('stock') : 0;
}
    
}
