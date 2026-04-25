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
}