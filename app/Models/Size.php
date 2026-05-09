<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'stock',
    ];

    protected $hidden = [
        'id',
    ];

    // Relación con el producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
