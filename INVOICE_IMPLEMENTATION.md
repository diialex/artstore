# Sistema de Envío de Facturas con Mailtrap - Implementación Completada

## Flujo de Funcionamiento

```
1. Usuario finaliza compra en Stripe → StripeController
2. Pago completado → Actualiza orden y pago a 'completed'
3. StripeController dispara evento → Event::dispatch(new OrderCreated($order))
4. EventServiceProvider escucha → Llama a SendInvoiceNotification listener
5. SendInvoiceNotification → Envía InvoiceMail a través de Mailtrap
6. InvoiceMail → Renderiza vista 'emails.invoice' con datos de la orden
```

## Archivos Creados

### 1. **Evento** - `app/Events/OrderCreated.php`
- Actúa como mensajero
- Contiene la orden recién creada
- Se dispara cuando el pago es completado

### 2. **Listener** - `app/Listeners/SendInvoiceNotification.php`
- Escucha el evento `OrderCreated`
- Implementa `ShouldQueue` para procesar en background
- Obtiene el email del usuario y envía la factura
- Registra éxito o error en logs

### 3. **Mailable** - `app/Mail/InvoiceMail.php`
- Construye el correo con asunto dinámico
- Define el remitente desde config
- Renderiza la vista `emails.invoice`
- Preparado para agregar PDF como adjunto si necesitas

### 4. **Vista** - `resources/views/emails/invoice.blade.php`
- Plantilla HTML del correo
- Muestra datos dinámicos (orden, items, totales)
- Usa componentes Laravel Mail (`<x-mail::*>`)
- Incluye botón para ver el pedido online

### 5. **Registro de Evento** - `app/Providers/AppServiceProvider.php`
```php
Event::listen(OrderCreated::class, SendInvoiceNotification::class);
```

### 6. **Modificación del Controlador** - `app/Http/Controllers/StripeController.php`
- Reemplazó envío directo de correo con disparo de evento
- Ahora es más limpio y separado de responsabilidades

## Configuración Mailtrap (Ya lista en .env)

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=b8e95f0587f40c
MAIL_PASSWORD=b22e2bb23de93c
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="ArtStore"
```

## Cómo Probar

1. Realiza una compra en tu aplicación
2. Completa el pago en Stripe
3. Revisa la bandeja de entrada de Mailtrap: https://mailtrap.io
4. Verifica los logs si hay errores: `storage/logs/laravel.log`

## Agregando PDF como Adjunto (Opcional)

Si necesitas adjuntar la factura en PDF:

```php
// En InvoiceMail.php
use Illuminate\Mail\Mailables\Attachment;

public function attachments(): array
{
    return [
        Attachment::fromPath(storage_path('invoices/order-'.$this->order->id.'.pdf'))
            ->as('factura.pdf')
            ->withMime('application/pdf'),
    ];
}
```

## Notas Importantes

- El listener implementa `ShouldQueue`, lo que significa que se procesa en background
- Si usas colas (queue), asegúrate de que `QUEUE_CONNECTION` esté configurado (actualmente: `database`)
- Los logs de envío se guardan en `storage/logs/laravel.log`
- Puedes cambiar el asunto, remitente o vista sin afectar el flujo
