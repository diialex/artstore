<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\AddressService;
use App\Services\OrderItemService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed;
use App\Services\RedisService;

class StripeController extends Controller {

    public function __construct(
        protected PaymentService $paymentService, 
        protected OrderService $orderService
    ) {}

    public function createCheckout(Request $request, $orderId) {
        
        if ($request->address_mode === 'saved') {
            $addressId = $request->address_id; 
        } else {
            $request->validate([
                'new_street' => 'required|string|max:255',
                'new_city' => 'required|string|max:255',
                'new_zip_code' => 'required|string|max:20',
            ], [
                'required' => 'Debes rellenar todos los campos de la nueva dirección.'
            ]);

            $address = Address::create([
                'user_id' => auth()->id(),
                'street' => $request->new_street,
                'city' => $request->new_city,
                'zip_code' => $request->new_zip_code,
            ]);
            $addressId = $address->id;
        }

        $stripe = new StripeClient(config('services.stripe.secret'));
        
        $orderService = new OrderService();
        $order = $orderService->find($orderId);
        
        $items = $order->items;

        // Pre-validación de stock antes de cobrar. Evita iniciar el pago de algo
        // que ya está agotado. La comprobación definitiva y atómica (que decide
        // quién se lleva la última unidad) se hace al confirmar el pago.
        foreach ($items as $item) {
            $available = $item->size ? (int) $item->size->stock : (int) $item->product->stock;
            if ($available < $item->quantity) {
                return redirect()->route('orders.carrito')
                    ->with('error', 'Algún artículo de tu bolsa ya no tiene stock suficiente. Revisa el carrito antes de pagar.');
            }
        }

        $lineItems = [];
        foreach ($items as $item) {
            
            $name = is_array($item) ? ($item['product']['title'] ?? 'Producto') : ($item->product->title ?? 'Producto');
            $price = is_array($item) ? $item['price'] : $item->price;
            $qty = is_array($item) ? $item['quantity'] : $item->quantity;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $name, 
                    ],
                    'unit_amount' => (int)($price * 100),
                ],
                'quantity' => $qty ?? 1,
            ];
        }

        $checkout = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'metadata' => [
                'order_id' => $order->id,
                'address_id' => $addressId 
            ],
            'success_url' => route('payments.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payments.cancel'),
        ]);

        $this->paymentService->create([
            'order_id'       => $order->id,
            'stripe_id'      => $checkout->id,
            'payment_method' => $checkout->payment_method_types[0],
            'status'         => 'pending',
            'shipping_address' => $addressId
        ]);

        return redirect($checkout->url);
    }
    
    public function successPayment(Request $request) {

        $sessionId = $request->query('session_id');
        $stripe = new StripeClient(config('services.stripe.secret'));
        $orderService = new OrderService();

        try {
            $session = $stripe->checkout->sessions->retrieve($sessionId);
            $order = $orderService->find($session->metadata->order_id);

            if ($session->payment_status === 'paid') {

                // Descuento de stock atómico: bloqueamos cada fila de stock
                // (talla o producto) con lockForUpdate dentro de una transacción
                // para que dos compras simultáneas no vendan la misma unidad.
                // Nunca dejamos el stock por debajo de 0; si falta, lo anotamos
                // como incidencia para resolución manual (el cobro ya se hizo).
                $stockIssues = DB::transaction(function () use ($order) {
                    $issues = [];

                    foreach ($order->items as $item) {
                        if ($item->size_id) {
                            $stockRow = Size::whereKey($item->size_id)->lockForUpdate()->first();
                        } else {
                            $stockRow = Product::whereKey($item->product_id)->lockForUpdate()->first();
                        }

                        if (!$stockRow) {
                            continue;
                        }

                        $available = (int) $stockRow->stock;

                        if ($available < $item->quantity) {
                            $issues[] = [
                                'product'   => $item->product->title ?? ('#' . $item->product_id),
                                'size'      => $item->size->size ?? null,
                                'requested' => $item->quantity,
                                'available' => $available,
                            ];
                        }

                        // Descontamos como mucho lo disponible; nunca negativo.
                        // El save() de Size dispara el recálculo de products.stock.
                        $stockRow->stock = max(0, $available - $item->quantity);
                        $stockRow->save();
                    }

                    return $issues;
                });

                RedisService::flushProducts();
                RedisService::flushProductsByCategory();

                $hasStockIssues = count($stockIssues) > 0;

                // El pago se completó en cualquier caso; si hubo conflicto de
                // stock marcamos el pedido como incidencia para resolverlo a mano.
                $order->update(['status' => $hasStockIssues ? 'incident' : 'completed']);

                $payment = $order->payments()->first();
                if($payment) {
                    $payment->update(['status' => 'completed']);
                }

                if ($hasStockIssues) {
                    Log::warning('Incidencia de stock en pedido ya pagado (resolución manual)', [
                        'order_id' => $order->id,
                        'issues'   => $stockIssues,
                    ]);
                }

                $customerEmail = $session->customer_details?->email ?? $order->user?->email;
                
                try {
                    if ($customerEmail) {
                        Mail::to($customerEmail)->send(new OrderConfirmed($order));
                    }
                } catch (\Exception $mailException) {
                    Log::error('Mail sending failed: ' . $mailException->getMessage());
                }

                return view('orders.success', [
                    'order' => $order,
                    'total' => $session->amount_total / 100,
                    'stockIssues' => $stockIssues,
                ]);
            }

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    function cancelPayment(Request $request){

    }
}