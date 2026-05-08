<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\AddressService;
use App\Services\OrderItemService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed; // Asegúrate de tener este Mailable creado

class StripeController extends Controller {

    public function __construct(
        protected PaymentService $paymentService, 
        protected OrderService $orderService
    ) {}

    public function createCheckout(Request $request, $orderId) {
        $stripe = new StripeClient(config('services.stripe.secret'));
        
        $orderService = new OrderService();
        $order = $orderService->find($orderId);
        
        $items = $order->items; 

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
                'address_id' => $request->address_id // Guardamos esto aquí para el success
            ],
            'success_url' => route('payments.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payments.cancel'),
        ]);

        $this->paymentService->create([
            'order_id'       => $order->id,
            'stripe_id'      => $checkout->id,
            'payment_method' => $checkout->payment_method_types[0],
            'status'         => 'pending',
            'shipping_address' => $request->address_id
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
                
                $order->update(['status' => 'completed']);
                
                $payment = $order->payments()->where('stripe_id', $sessionId)->first();
                if($payment) {
                    $payment->update(['status' => 'completed']);
                }

                Mail::to($order->user->email)->send(new OrderConfirmed($order));

                return view('payments.success', [
                    'customer_email' => $session->customer_details->email,
                    'total' => $session->amount_total / 100,
                ]);
            }

            return redirect()->route('home')->with('error', 'El pago no se completó.');

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error: ' . $e->getMessage());
        }
    }
}