<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de tu pedido</title>
</head>
<body style="margin:0; padding:0; background:#f6f7f9; color:#212529; font-family:Arial, Helvetica, sans-serif;">
    <div style="max-width:760px; margin:0 auto; padding:32px 16px;">
        <div style="background:#ffffff; border:1px solid #e9ecef; border-radius:8px; overflow:hidden;">
            <div style="padding:28px 32px; background:#212529; color:#ffffff;">
                <h1 style="margin:0; font-size:24px; line-height:1.25;">Factura</h1>
                <p style="margin:8px 0 0; color:#dfe3e6;">
                    {{ $invoice?->invoice_number ?? 'Pedido #' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>

            <div style="padding:28px 32px;">
                @if($invoice)
                    <table style="width:100%; border-collapse:collapse; margin-bottom:28px;">
                        <tr>
                            <td style="vertical-align:top; width:50%; padding-right:16px;">
                                <p style="margin:0 0 6px; font-size:12px; color:#6c757d; text-transform:uppercase; font-weight:bold;">Cliente</p>
                                <p style="margin:0; font-size:15px; font-weight:bold;">{{ $invoice?->customer_name ?? $invoice?->customer_username }}</p>
                                <p style="margin:4px 0 0; font-size:14px; color:#495057;">{{ $invoice->customer_email }}</p>
                                @if($invoice->customer_phone)
                                    <p style="margin:4px 0 0; font-size:14px; color:#495057;">{{ $invoice->customer_phone }}</p>
                                @endif
                            </td>
                            <td style="vertical-align:top; width:50%; padding-left:16px;">
                                <p style="margin:0 0 6px; font-size:12px; color:#6c757d; text-transform:uppercase; font-weight:bold;">Entrega</p>
                                <p style="margin:0; font-size:14px; color:#495057;">{{ $invoice->shipping_street ?? 'Direccion no disponible' }}</p>
                                <p style="margin:4px 0 0; font-size:14px; color:#495057;">
                                    {{ $invoice->shipping_city ?? '' }} {{ $invoice->shipping_zip_code ? '(' . $invoice->shipping_zip_code . ')' : '' }}
                                </p>
                            </td>
                        </tr>
                    </table>

                    <table style="width:100%; border-collapse:collapse; margin-bottom:24px;">
                        <tr>
                            <td style="padding:12px; border:1px solid #e9ecef; background:#f8f9fa;">
                                <p style="margin:0; font-size:12px; color:#6c757d; text-transform:uppercase; font-weight:bold;">Fecha</p>
                                <p style="margin:6px 0 0; font-size:14px;">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y H:i') }}</p>
                            </td>
                            <td style="padding:12px; border:1px solid #e9ecef; background:#f8f9fa;">
                                <p style="margin:0; font-size:12px; color:#6c757d; text-transform:uppercase; font-weight:bold;">Pago</p>
                                <p style="margin:6px 0 0; font-size:14px;">{{ ucfirst($invoice->payment_method ?? 'pendiente') }}</p>
                            </td>
                            <td style="padding:12px; border:1px solid #e9ecef; background:#f8f9fa;">
                                <p style="margin:0; font-size:12px; color:#6c757d; text-transform:uppercase; font-weight:bold;">Estado</p>
                                <p style="margin:6px 0 0; font-size:14px;">{{ ucfirst($invoice->payment_status ?? $invoice->order_status) }}</p>
                            </td>
                        </tr>
                    </table>
                @endif

                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th align="left" style="padding:12px; border-bottom:2px solid #212529; font-size:12px; text-transform:uppercase;">Producto</th>
                            <th align="center" style="padding:12px; border-bottom:2px solid #212529; font-size:12px; text-transform:uppercase;">Talla</th>
                            <th align="center" style="padding:12px; border-bottom:2px solid #212529; font-size:12px; text-transform:uppercase;">Cant.</th>
                            <th align="right" style="padding:12px; border-bottom:2px solid #212529; font-size:12px; text-transform:uppercase;">Precio</th>
                            <th align="right" style="padding:12px; border-bottom:2px solid #212529; font-size:12px; text-transform:uppercase;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoiceLines as $line)
                            <tr>
                                <td style="padding:14px 12px; border-bottom:1px solid #e9ecef;">{{ $line->product_title }}</td>
                                <td align="center" style="padding:14px 12px; border-bottom:1px solid #e9ecef;">{{ $line->product_size }}</td>
                                <td align="center" style="padding:14px 12px; border-bottom:1px solid #e9ecef;">{{ $line->quantity }}</td>
                                <td align="right" style="padding:14px 12px; border-bottom:1px solid #e9ecef;">{{ number_format($line->unit_price, 2) }} €</td>
                                <td align="right" style="padding:14px 12px; border-bottom:1px solid #e9ecef; font-weight:bold;">{{ number_format($line->line_total, 2) }} €</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding:18px 12px; color:#6c757d;">No hay lineas de factura disponibles para este pedido.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <table style="width:100%; border-collapse:collapse; margin-top:24px;">
                    <tr>
                        <td align="right" style="padding:8px 0; font-size:15px; color:#6c757d;">Subtotal</td>
                        <td align="right" style="padding:8px 0; width:140px; font-size:15px;">{{ number_format($invoice->order_total ?? $order->total_amount, 2) }} €</td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:8px 0; font-size:15px; color:#6c757d;">Envio</td>
                        <td align="right" style="padding:8px 0; font-size:15px;">Gratis</td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:14px 0 0; font-size:18px; font-weight:bold; border-top:1px solid #e9ecef;">Total</td>
                        <td align="right" style="padding:14px 0 0; font-size:20px; font-weight:bold; border-top:1px solid #e9ecef;">{{ number_format($invoice->order_total ?? $order->total_amount, 2) }} €</td>
                    </tr>
                </table>

                <p style="margin:28px 0 0; font-size:14px; color:#6c757d;">
                    Gracias por tu compra. Este correo ha sido enviado automaticamente.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
