<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $order)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Factura de tu pedido',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $invoiceLines = DB::table('order_invoice_lines')
            ->where('order_id', $this->order->id)
            ->orderBy('line_id')
            ->get();

        $invoice = $invoiceLines->first();

        return new Content(
            view: 'emails.order_confirmed',
            with: [
                'invoice' => $invoice,
                'invoiceLines' => $invoiceLines,
                'order' => $this->order,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
