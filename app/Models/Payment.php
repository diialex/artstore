<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_method',
        'status',
        'shipping_address',
    ];

    protected $hidden = [
        'id'
    ];

    protected $appends = ['amount'];  

    public const PAGINATE = 10; 

    
    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function getAmountAttribute(){
        return $this->order?->total_amount ?? 0;
    }

    public function changeCompleted(){
        $this->status = 'completed';
    }

    public function changePending(){
        $this->status = 'pending';
    }
}
