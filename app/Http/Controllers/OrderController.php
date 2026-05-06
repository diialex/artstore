<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService){
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = $this->orderService->getAll();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('orders.form', [ 'order' => new Order() ]);
    }

    public function addProducttoOrder(Product $product)
    {

        $order = new Order;
        $order->total_amount = $product->price;
        $order->user()->associate(auth()->user());
        $order->save();

        $item= $order->items()->where('product_id', $product->id)->first();
        if ($item){
            $item->quantity = $item->quantity + 1;
            $item->price = $product->price;
            $item->save();
        }else{
            $item = new OrderItem;
            $item->quantity =1;
            $item->price = $product->price;
            $item->order()->associate($order);
            $item->product()->associate($product);
            $order->items()->save($item);
        }


        $total = 0;
        foreach ($order->items as $item) {
            $total += $item->price * $item->quantity;
        }
        $order->update(['total_amount' => $total]);
        $this->orderService->update($order);

        return redirect()->route('orders.carrito')->with('success', 'Producto agregado a la orden exitosamente.');
    }

    public function carrito(){
        $order = Order::where('user_id',auth()->user())->where('status', 'pending')->orWhere('status', 'failed')->first();
        if (!$order){
            $orderService = new OrderService();
            $order= new Order;
            $order->user()->associate(auth()->user());
            $order->total_amount=0;
            $order=$orderService->save($order);
        }
        $order=$this->updateOrder($order);
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
}
