<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['name', 'image'];

    protected $hidden = [
        'id',
    ];

    public array $translatable = ['name'];

    // Relación N:M con Productos
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}