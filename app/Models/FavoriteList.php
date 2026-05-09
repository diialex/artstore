<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteList extends Model
{
    protected $table = 'lista_favoritos';
    protected $fillable = ['user_id', 'products'];
    protected $casts = [
        'products' => 'array',  // Laravel convierte JSON ↔ array automáticamente
    ];
}
