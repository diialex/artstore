<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;

    protected $table = 'product_sizes';
    protected $fillable = [
        'id',
        'product_id',
        'size',
        'stock',
    ];

    // Relación con el producto
    public function product()
    {
    return $this->belongsTo(Product::class);
    }
}
