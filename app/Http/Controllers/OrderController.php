<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Size;
use App\Services\GuestCartService;
use App\Services\OrderService;
use App\Mail\OrderConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService, protected GuestCartService $guestCartService){
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role_id == 1) { 
            $orders = Order::where('status', '!=', 'pending')
                        ->orderBy('created_at', 'desc')
                        ->get();
            return view('admin.orders.index', compact('orders')); // Una vista de tabla/gestión
        }

        $orders = Order::where('user_id', $user->id)
                    ->where('status', '!=', 'pending')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('orders.index', compact('orders')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('orders.form', [ 'order' => new Order() ]);
    }
    public function addProducttoOrder(Request $request, Product $product)
    {
        $request->validate([
            'size_id' => 'required|exists:sizes,id',
        ]);

        if (Auth::guest()) {
            $this->guestCartService->addItem($product, 1, $request->size_id);
        } else {
            $size_id = $request->size_id;
            $user = Auth::user();

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

            $item = $order->items()
                        ->where('product_id', $product->id)
                        ->where('size_id', $size_id)
                        ->first();

            if ($item) {
                $item->quantity += 1;
                $item->save();
            } else {
                $item = new OrderItem;
                $item->quantity = 1;
                $item->price = $product->price;
                $item->order()->associate($order);
                $item->product()->associate($product);
                $item->size()->associate($size_id);
                $item->save();
            }

            $this->updateOrder($order);
        }
        
        return redirect()->route('orders.carrito')->with('success', 'Producto agregado exitosamente.');
    }

    public function carrito()
    {
        if (Auth::guest()) {
            $cartData = $this->guestCartService->getCart();
            $order = (object) [
                'items' => collect($cartData['items'])->map(function ($i) {
                    $sizeId = $i['size_id'] ?? null;
                    return (object) [
                        'product_id' => $i['product_id'],
                        'size_id'    => $sizeId,
                        'product'    => Product::find($i['product_id']),
                        'size'       => $sizeId ? Size::find($sizeId) : null,
                        'price'      => $i['price'],
                        'quantity'   => $i['quantity'],
                    ];
                }),
                'total_amount' => $cartData['total_amount'],
            ];
            return view('orders.carrito', compact('order'));
        }
        
        $user_id = Auth::id();
        
        $order = Order::where('user_id', $user_id)
                    ->where(function($query) {
                    $query->where('status', 'pending')
                    ->orWhere('status', 'failed');
                    })->first();

        if (!$order) {
            $order = new Order;
            $order->user()->associate(Auth::user());
            $order->total_amount = 0;
            $order->status = 'pending';
            $order->save();
        }

        $order = $this->updateOrder($order);
        return view('orders.carrito', compact('order'));
    }
        

    public function updateOrder(Order $order){
        $total = 0;
        foreach ($order->items as $item) {
            $total += $item->price * $item->quantity;
        }
        $order->update(['total_amount' => $total]);
        $this->orderService->update($order);
        return $order;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $this->orderService->create($request->validated());

        return redirect()->route('orders.index')->with('success', 'Orden creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $order = $this->orderService->find($id);
        return view('orders.form', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, int $id)
    {
        $order = $this->orderService->find($id);
        $order->update($request->validated());
        $this->orderService->update($order);
        return redirect()->route('orders.index')->with('success', 'Orden actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->orderService->delete($id);
        return redirect()->route('orders.index')->with('success', 'Orden eliminada exitosamente.');
    }

    public function pay(Request $request, Order $order)
    {
        $request->validate(['address_id' => 'required|exists:addresses,id']);

        $order->update([
            'status' => 'completed',
            'address_id' => $request->address_id,
            'order_date' => now()
        ]);

        Mail::to($order->user->email)->send(new OrderConfirmed($order));

        return redirect()->route('home')->with('success_order', '¡Pedido realizado con éxito! Revisa tu email :).');
    }

    public function guestIncreaseItem(Request $request)
    {
        $this->guestCartService->addOne((int) $request->product_id);
        return redirect()->route('orders.carrito');
    }

    public function guestDecreaseItem(Request $request)
    {
        if ($request->remove_all) {
            $this->guestCartService->removeItem((int) $request->product_id);
        } else {
            $this->guestCartService->removeOne((int) $request->product_id);
        }
        return redirect()->route('orders.carrito');
    }

    public function increaseItem(OrderItem $item)
    {
        if($item->size->stock>$item->quantity){
            $item->quantity += 1;
            $item->save();
        }
        
        
        $this->orderService->updateOrderTotal($item->order);
        
        return redirect()->route('orders.carrito');
    }

    public function decreaseItem(OrderItem $item)
    {
        $order = $item->order; 

        if ($item->quantity > 1) {
            $item->quantity -= 1;
            $item->save();
        } else {
            $item->delete();
        }
        $this->orderService->updateOrderTotal($order);
        
        return redirect()->route('orders.carrito');
    }
}
