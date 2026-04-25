<?php

namespace App\Services;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

class PaymentService
{
    public function getAll(): Collection
    {
        return Payment::all();
    }

    public function find(int $id): Payment
    {
        return Payment::findOrFail($id);
    }


    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public function update(Payment $payment): bool
    {
        $payment->save();
        return true;
    }

    public function delete(int $id): bool
    {
        $payment = $this->find($id);
        $payment->delete();
        return true;
    }
}