<x-mail::message>
# ¡Gracias por tu compra, {{ $order->user->name }}!

Aquí tienes los detalles de tu pedido.

**Número de Orden:** #{{ $order->id }}
**Fecha:** {{ $order->created_at->format('d/m/Y') }}
**Estado:** {{ $order->status }}

## Detalles de tu Compra

<x-mail::table>
| Producto       | Cantidad         | Precio Unitario  | Subtotal |
| :--------- | :------------- | :-------- | :-------- |
@foreach($order->items as $item)
| {{ $item->product->title }} | {{ $item->quantity }} | ${{ number_format($item->price, 2) }} | ${{ number_format($item->price * $item->quantity, 2) }} |
@endforeach
</x-mail::table>

**Total:** ${{ number_format($order->total_amount, 2) }}

---

<x-mail::button :url="route('orders.show', $order->id)">
Ver mi pedido online
</x-mail::button>

Si tienes alguna duda, responde a este correo.

Saludos,<br>
El equipo de {{ config('app.name') }}
</x-mail::message>
