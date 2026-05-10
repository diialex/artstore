<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'image_url'];
    
    protected $hidden = [
        'id',
    ];
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
    
}
