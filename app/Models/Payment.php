<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'status',
    ];

    public const PAGINATE = 10; //this shows the number of payments per page when paginating results

    
    public function order(){
        return $this->hasOne(Order::class);
    }

    public function getAmountAttribute(){
        return $this->order->total_amount;
    }
}
