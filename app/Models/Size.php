<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;

    protected $table = 'product_sizes'; // Especificamos el nombre de la tabla

    protected $fillable = [
        'product_id',
        'size',
        'stock',
        'is_approved'
    ];

    // Relación con el producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
