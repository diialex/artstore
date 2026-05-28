<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Constants\RedisConstants;

class GuestCartService
{
    private string $cartID;

    public function __construct()
    {
        if (!Session::has('guest_cart_id')) {
            Session::put('guest_cart_id', Str::uuid()->toString());
        }
        $this->cartID = RedisConstants::CART_GUEST . Session::get('guest_cart_id');
    }

    public function createGuestCart(): void
    {
        if (!Redis::exists($this->cartID)) {
            Redis::set($this->cartID, json_encode(['items' => [], 'total_amount' => 0]));
            Redis::expire($this->cartID, 604800);
        }
    }

    public function addItem(Product $product, int $quantity = 1, ?int $sizeId = null): void
    {
        $this->createGuestCart();

        $cart = json_decode(Redis::get($this->cartID), true);

        foreach ($cart['items'] as &$item) {
            if ($item['product_id'] === $product->id && $item['size_id'] === $sizeId) {
                $item['quantity'] += $quantity;
                $cart['total_amount'] += $product->price * $quantity;
                Redis::set($this->cartID, json_encode($cart));
                return;
            }
        }

        $cart['items'][] = [
            'product_id' => $product->id,
            'size_id'    => $sizeId,
            'title'      => $product->title,
            'price'      => $product->price,
            'quantity'   => $quantity,
        ];
        $cart['total_amount'] += $product->price * $quantity;

        Redis::set($this->cartID, json_encode($cart));
    }

    public function addOne(int $productId): void
    {
        if (!Redis::exists($this->cartID)) {
            return;
        }

        $cart = json_decode(Redis::get($this->cartID), true);

        foreach ($cart['items'] as &$cartItem) {
            if ($cartItem['product_id'] === $productId) {
                $cartItem['quantity'] += 1;
                $cart['total_amount'] += $cartItem['price'];
                break;
            }
        }

        Redis::set($this->cartID, json_encode($cart));
    }

    public function removeOne(int $productId): void
    {
        if (!Redis::exists($this->cartID)) {
            return;
        }

        $cart = json_decode(Redis::get($this->cartID), true);

        foreach ($cart['items'] as $index => &$cartItem) {
            if ($cartItem['product_id'] === $productId) {
                if ($cartItem['quantity'] <= 1) {
                    $cart['total_amount'] -= $cartItem['price'];
                    array_splice($cart['items'], $index, 1);
                } else {
                    $cartItem['quantity'] -= 1;
                    $cart['total_amount'] -= $cartItem['price'];
                }
                break;
            }
        }

        Redis::set($this->cartID, json_encode($cart));
    }

    public function removeItem(int $productId, int $quantity = 1): void
    {
        if (!Redis::exists($this->cartID)) {
            return;
        }

        $cart = json_decode(Redis::get($this->cartID), true);

        foreach ($cart['items'] as $index => $item) {
            if ($item['product_id'] === $productId) {
                if ($item['quantity'] <= $quantity) {
                    $cart['total_amount'] -= $item['price'] * $item['quantity'];
                    array_splice($cart['items'], $index, 1);
                } else {
                    $cart['items'][$index]['quantity'] -= $quantity;
                    $cart['total_amount'] -= $item['price'] * $quantity;
                }
                break;
            }
        }

        Redis::set($this->cartID, json_encode($cart));
    }

    public function getCart(): array
    {
        if (!Redis::exists($this->cartID)) {
            return ['items' => [], 'total_amount' => 0];
        }
        return json_decode(Redis::get($this->cartID), true);
    }

    public function checkout(int $userId): Order
    {
        $cart = $this->getCart();

        if($cart != null){
            $order = Order::create([
            'user_id'      => $userId,
            'total_amount' => $cart['total_amount'],
            'status'       => 'pending',
        ]);

        foreach ($cart['items'] as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'],
                'price'      => $item['price'],
                'quantity'   => $item['quantity'],
            ]);
        }

        Redis::del($this->cartID);

        return $order;
        }
    }

    public function mergeIntoUserOrder(User $user): void
    {
        $cart = $this->getCart();

        if (empty($cart['items'])) {
            return;
        }

        $order = Order::where('user_id', $user->id)
                      ->whereIn('status', ['pending', 'failed'])
                      ->first();

        if (!$order) {
            $order = new Order;
            $order->total_amount = 0;
            $order->status = 'pending';
            $order->user()->associate($user);
            $order->save();
        }

        foreach ($cart['items'] as $cartItem) {
            $existing = $order->items()
                              ->where('product_id', $cartItem['product_id'])
                              ->where('size_id', $cartItem['size_id'] ?? null)
                              ->first();

            if ($existing) {
                $existing->quantity += $cartItem['quantity'];
                $existing->save();
            } else {
                $item = new OrderItem;
                $item->quantity = $cartItem['quantity'];
                $item->price    = $cartItem['price'];
                $item->order()->associate($order);
                $item->product()->associate($cartItem['product_id']);
                if (!empty($cartItem['size_id'])) {
                    $item->size()->associate($cartItem['size_id']);
                }
                $item->save();
            }
        }

        $total = $order->fresh()->items->sum(fn($i) => $i->price * $i->quantity);
        $order->update(['total_amount' => $total]);

        Redis::del($this->cartID);
        Session::forget('guest_cart_id');
    }
}
