# Análisis del Flujo de Email al Registrarse

## 🔴 ESTADO ACTUAL: NO HAY ENVÍO DE EMAIL

### Flujo Actual (Incompleto)

```
1. Usuario rellena formulario de registro
   ↓
2. Fortify → CreateNewUser::create()
   ↓
3. User::create() - Se crea en BD
   ↓
4. Laravel dispara evento Registered automáticamente
   ↓
5. ❌ NO HAY LISTENER escuchando
   ↓
6. ❌ NO SE ENVÍA EMAIL DE BIENVENIDA
```

## ✅ LO QUE FALTA IMPLEMENTAR

### 1. **Mailable de Bienvenida** (`app/Mail/WelcomeMail.php`)
```php
class WelcomeMail extends Mailable
{
    public function __construct(public User $user) {}
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Bienvenido a ArtStore!'
        );
    }
    
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome'
        );
    }
}
```

### 2. **Listener para Registered** (`app/Listeners/SendWelcomeNotification.php`)
```php
class SendWelcomeNotification
{
    public function handle(Registered $event): void
    {
        Mail::to($event->user->email)->send(new WelcomeMail($event->user));
    }
}
```

### 3. **Registro en AppServiceProvider**
```php
Event::listen(Registered::class, SendWelcomeNotification::class);
```

### 4. **Vista del Email** (`resources/views/emails/welcome.blade.php`)
```blade
<x-mail::message>
# ¡Bienvenido {{ $user->name }}!

Gracias por registrarte en ArtStore.

<x-mail::button :url="route('home')">
Explorar Tienda
</x-mail::button>

Si tienes preguntas, contáctanos.
</x-mail::message>
```

## 📊 Comparativa

| Sistema | Estado | Email | Evento | Listener |
|---------|--------|-------|--------|----------|
| **Compra (OrderCreated)** | ✅ Implementado | InvoiceMail | OrderCreated | SendInvoiceNotification |
| **Registro (Registered)** | ❌ Falta | WelcomeMail (no existe) | Registered (no escuchado) | SendWelcomeNotification (no existe) |

## 📝 Archivos Actuales

- `app/Actions/Fortify/CreateNewUser.php` - Solo crea el usuario, sin disparar eventos adicionales
- `app/Providers/AppServiceProvider.php` - Solo escucha OrderCreated, no Registered
- `resources/views/emails/order_confirmed.blade.php` - **ESTÁ VACÍO**

## 🚀 Recomendación

Implementar el flujo de bienvenida para mantener consistencia con el sistema de facturas:

1. Crear Mailable `WelcomeMail.php`
2. Crear Listener `SendWelcomeNotification.php`
3. Crear vista `resources/views/emails/welcome.blade.php`
4. Registrar en `AppServiceProvider.php`
5. Usar `Illuminate\Auth\Events\Registered`
