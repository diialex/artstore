<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Services\AddressService;
use App\Services\OrderItemService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed; 

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

                foreach($order->items as $item) {
                    $item->size->stock -= $item->quantity;
                    $item->size->save();
                }
                
                $order->update(['status' => 'completed']);
                
                $payment = $order->payments()->first();
                if($payment) {
                    $payment->update(['status' => 'completed']);
                }

                

                $customerEmail = $session->customer_details?->email ?? $order->user?->email;
                
                try {
                    if ($customerEmail) {
                        Mail::to($customerEmail)->send(new OrderConfirmed($order));
                    }
                } catch (\Exception $mailException) {
                    \Illuminate\Support\Facades\Log::error('Mail sending failed: ' . $mailException->getMessage());
                }

                return redirect()->route('home', [
                    'customer_email' => $customerEmail,
                    'total' => $session->amount_total / 100,
                ]);
            }

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    function cancelPayment(Request $request){

    }
}