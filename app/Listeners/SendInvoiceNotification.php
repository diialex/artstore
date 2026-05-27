<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\InvoiceMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendInvoiceNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        try {
            $order = $event->order;
            $customerEmail = $order->user->email;

            if ($customerEmail) {
                Mail::to($customerEmail)->send(new InvoiceMail($order));
                Log::info("Invoice sent successfully for order #{$order->id}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send invoice: " . $e->getMessage());
        }
    }
}
