<?php

namespace App\Services;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function getAll(): Collection
    {
        return Order::all();
    }

    public function find(int $id): Order
    {
        return Order::findOrFail($id);
    }

    public function save(Order $order){
        if (!$order->exists) {
        $order->status = 'pending';
        }
        
        // Si ya existe y no tiene estado, también lo ponemos
        if (empty($order->status)) {
            $order->status = 'pending';
        }

        $order->save();
        return $order;
    }


    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(Order $order): bool
    {
        $order->save();
        return true;
    }

    public function delete(int $id): bool
    {
        $order = $this->find($id);
        $order->delete();
        return true;
    }


    public function updateOrderTotal(Order $order)
    {
        $total = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $order->update(['total_amount' => $total]);

        return $order;
    }
}