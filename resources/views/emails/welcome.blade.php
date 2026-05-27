<x-mail::message>
# ¡Bienvenido a {{ config('app.name') }}, {{ $user->name }}!

Te damos la más cordial bienvenida a nuestro mundo de arte y artesanía.

Tu cuenta ha sido creada exitosamente con los siguientes datos:

- **Nombre:** {{ $user->name }}
- **Email:** {{ $user->email }}
- **Usuario:** {{ $user->username }}

Ahora puedes explorar nuestro catálogo completo de productos artesanales y realizar tus compras.

<x-mail::button :url="route('home')">
Explorar Tienda
</x-mail::button>

## ¿Qué puedes hacer ahora?

- 🛍️ Navegar por nuestro catálogo de productos
- ❤️ Agregar productos a tu lista de favoritos
- 📦 Realizar compras y hacer seguimiento de tus órdenes
- 👤 Actualizar tu perfil y direcciones de envío

Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos respondiendo a este correo.

¡Que disfrutes tu experiencia en {{ config('app.name') }}!

Saludos cordiales,<br>
El equipo de {{ config('app.name') }}
</x-mail::message>
