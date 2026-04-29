<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\AddressService;
use App\Services\OrderItemService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Stripe\StripeClient;
use Illuminate\Http\Request;

class StripeController extends Controller{

    public function __construct(protected PaymentService $paymentService, protected OrderController $orderService){

    }
    public function createCheckout(Request $request, $orderId) {
        $addressesService = new AddressService();
        $orderItemService = new OrderItemService;
        $orderService = new OrderService();
        $paymentService = new PaymentService();
        $stripe = new StripeClient(config('services.stripe.secret'));
        $order = $orderService->find($orderId);
        $items = $orderItemService->getAllByOrder($order); 
        $address = $addressesService->get($request->address_id);
        $lineItems = [];
        foreach ($items as $item) {
            $lineItems[] = [
                
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->product->name ?? $item->product->name, 
                    ],
                    'unit_amount' => $item->price * 100, // Precio en centavos
                ],
                'quantity' => $item->quantity ?? 1,
            ];
        }

        $checkout = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'metadata' => [
                'order_id' => $order->id
            ],
            'success_url' => route('payments.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payments.cancel'),
        ]);

        
        $paymentService->create([
            'order_id'       => $order->id,
            'stripe_id'      => $checkout->id,
            'payment_method' => $checkout->payment_method_types[0],
            'status'         => 'pending',
            'shipping_address' => $request->input('address_id')
        ]);

        
        return redirect($checkout->url);
    }
    
    public function successPayment(Request $request, $sessionId){
        $stripe = new StripeClient(config('services.stripe.secret'));
        $paymentService = new PaymentService();
        $orderService = new OrderService();
        try {
            $session = $stripe->checkout->sessions->retrieve($sessionId);
            $order = $orderService->find($session->metadata->order_id);
            if ($session->payment_status === 'paid') {
                
                $payment=$order->payments()->changeCompleted();
                

                return view('payments.success', [
                    'customer_email' => $session->customer_details->email,
                    'total' => $session->amount_total / 100,
                ]);
            }

            return redirect()->route('home')->with('error', 'El pago no se completó.');

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error al recuperar el pago: ' . $e->getMessage());
        }
    }
}

