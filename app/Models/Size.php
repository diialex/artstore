<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;

    protected $table = 'sizes';

    protected $touches = ['product'];

    protected $fillable = [
        'id',
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

    protected static function booted()
    {
        // Esta función se ejecutará cada vez que algo cambie en las tallas
        $recalculateProductStock = function ($size) {
            $product = $size->product;
            if ($product) {
                // Sumamos los stocks de todas las tallas de este producto
                $total = $product->sizes()->sum('stock');
                
                // Guardamos el total directamente en la tabla 'products'
                // Usamos 'save()' o 'update()' para persistirlo en la DB
                $product->stock = $total;
                $product->save();
            }
        };

        static::saved($recalculateProductStock);   // Al crear o editar talla
        static::deleted($recalculateProductStock); // Al eliminar una talla
    }
}
