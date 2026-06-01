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

        
        if ($user->roles->contains('id', 1)) { 
            
            $orders = Order::where('status', '!=', 'pending')
                        ->orderBy('created_at', 'desc')
                        ->get();
                        
            
            return view('orders.index', compact('orders')); 
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
        // este producto tiene tallas en la base de datos?
        $hasSizes = $product->sizes()->exists();

        $request->validate([
            // Si tiene tallas es obligatorio. Si no, permitimos null.
            'size_id' => $hasSizes ? 'required|exists:sizes,id' : 'nullable',
        ]);

        $sizeId = $request->size_id ? (int) $request->size_id : null;

        // Stock disponible: por talla si la tiene, si no a nivel de producto.
        // Es solo un control de UX; la comprobación definitiva y atómica se hace
        // al confirmar el pago (otra persona podría llevarse la unidad antes).
        $availableStock = $sizeId
            ? (int) (Size::find($sizeId)?->stock ?? 0)
            : (int) $product->stock;

        if (Auth::guest()) {
            $currentQuantity = 0;
            foreach ($this->guestCartService->getCart()['items'] as $cartItem) {
                if ($cartItem['product_id'] === $product->id && ($cartItem['size_id'] ?? null) === $sizeId) {
                    $currentQuantity = $cartItem['quantity'];
                    break;
                }
            }

            if ($currentQuantity + 1 > $availableStock) {
                return redirect()->back()->with('error', 'No queda stock disponible de este artículo.');
            }

            $this->guestCartService->addItem($product, 1, $sizeId);
        } else {
            $user = Auth::user();

            $order = Order::where('user_id', $user->id)
                        ->whereIn('status', ['pending', 'failed'])
                        ->first();

            // Buscamos si ya existe este producto con esta talla (o sin talla) en el carrito
            $item = $order?->items()
                        ->where('product_id', $product->id)
                        ->where('size_id', $sizeId)
                        ->first();

            if (($item?->quantity ?? 0) + 1 > $availableStock) {
                return redirect()->back()->with('error', 'No queda stock disponible de este artículo.');
            }

            if (!$order) {
                $order = new Order;
                $order->total_amount = 0;
                $order->status = 'pending';
                $order->user()->associate($user);
                $order->save();
            }

            if ($item) {
                $item->quantity += 1;
                $item->save();
            } else {
                $item = new OrderItem;
                $item->quantity = 1;
                $item->price = $product->price;
                $item->order()->associate($order);
                $item->product()->associate($product);

                // Solo asociamos la talla si realmente nos enviaron una
                if ($sizeId) {
                    $item->size()->associate($sizeId);
                }

                $item->save();
            }

            $this->updateOrder($order);
        }

        return redirect()->back()->with('success', 'Producto añadido al carrito.');
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
        if (auth()->user()->roles->contains('id', 2) && $order->user_id !== auth()->id()) {
        abort(403);
        }
        $order->load(['items.product', 'items.size', 'address', 'user']);

        // Devolvemos la vista que acabamos de crear pasándole el pedido
        return view('orders.show', compact('order'));
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
        $productId = (int) $request->product_id;
        $sizeId    = $request->size_id ? (int) $request->size_id : null;

        $cart = $this->guestCartService->getCart();
        $currentQuantity = 0;
        foreach ($cart['items'] as $item) {
            if ($item['product_id'] === $productId && $item['size_id'] === $sizeId) {
                $currentQuantity = $item['quantity'];
                break;
            }
        }

        $availableStock = $sizeId
            ? (Size::find($sizeId)?->stock ?? 0)
            : (Product::find($productId)?->stock ?? 0);

        if ($availableStock > $currentQuantity) {
            $this->guestCartService->addOne($productId);
        }

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
        $availableStock = $item->size ? $item->size->stock : $item->product->stock;

        if($availableStock > $item->quantity){
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
