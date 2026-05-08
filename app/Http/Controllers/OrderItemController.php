<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItem\StoreOrderItemRequest;
use App\Http\Requests\OrderItem\UpdateOrderItemRequest;
use App\Services\OrderItemService;
use App\Models\OrderItem;
use App\Models\Order;
// use App\Models\Product;

class OrderItemController extends Controller
{

    public function __construct(protected OrderItemService $service)
    {
        protected OrderItemService $service,
        protected OrderService $orderService

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderitems = $this->service->getAll();
        return view("orderitems.index", compact('orderitems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orderItem = new OrderItem();
        $orders = Order::all();
        // $products = Product::all();
        return view('orderitems.form', compact('orderItem', 'orders')); // 'products'
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderItemRequest $request)
    {
        $orderItem = $this->service->create($request->validated());
        return redirect()->route('orderitems.index')->with('success', 'Order Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $orderItem = $this->service->find($id);
        $orders = Order::all();
        // $products = Product::all();
        return view('orderitems.form', compact('orderItem', 'orders')); // 'products'
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderItemRequest $request, int $id)
    {
        $orderItem = $this->service->find($id);
        $orderItem->update($request->validated());
        $this->service->update($orderItem);
        
        return redirect()->route('orderitems.index')->with('success', 'Order Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
       $item = $this->service->find($id);
        $order = $item->order; 
        
        $this->service->delete($id);
    
        this->orderService->updateOrderTotal($order);
        
        return redirect()->route('orders.carrito')->with('success', 'Artículo eliminado de la cesta.');
    }
}
