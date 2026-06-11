@component('mail::message')
# ¡Hola, {{ $nombre }}! 👋

Gracias por registrarte en **STATELESS**. Solo falta un paso:

@component('mail::button', ['url' => $url, 'color' => 'success'])
Verificar mi cuenta
@endcomponent

Este enlace expira en **24 horas**.

Si no creaste esta cuenta, ignora este correo.

— El equipo de STATELESS
@endcomponent