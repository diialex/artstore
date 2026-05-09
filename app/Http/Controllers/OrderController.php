<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\OrderService;
use App\Mail\OrderConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService){
        
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
        $user = Auth::user();

        $order = Order::where('user_id', $user->id)
                    ->whereIn('status', ['pending', 'failed'])
                    ->first();

        if (!$order) {
            $order = new Order;
            $order->total_amount = 0;
            $order->user()->associate($user);
        
            $this->orderService->save($order); 
        }

        $item = $order->items()->where('product_id', $product->id)->first();
        
        if ($item) {
            $item->quantity += 1;
            $item->save();
        } else {
            $item = new OrderItem;
            $item->quantity = 1;
            $item->price = $product->price;
            $item->order()->associate($order);
            $item->product()->associate($product);
            $item->save();
        }

        $this->updateOrder($order);
        return redirect()->route('orders.carrito')->with('success', 'Producto agregado exitosamente.');
    }

    public function carrito()
    {
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

    public function increaseItem(OrderItem $item)
    {
        $item->quantity += 1;
        $item->save();
        
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
