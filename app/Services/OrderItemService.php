<?php

namespace App\Services;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;

class OrderItemService{
    
    public function getAll(): Collection
    {
        return OrderItem::all();
    }

    public function find(int $id): OrderItem
    {
        return OrderItem::findOrFail($id);
    }


    public function create(array $data): OrderItem
    {
        return OrderItem::create($data);
    }

    public function update(OrderItem $orderItem): bool
    {
        $orderItem->save();
        return true;
    }

    public function delete(int $id): bool
    {
        $orderItem = $this->find($id);
        $orderItem->delete();
        return true;
    }
}