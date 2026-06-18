@component('mail::message')
# Recuperar contraseña 🔑

Hola **{{ $nombre }}**, recibimos una solicitud para restablecer tu contraseña.

@component('mail::button', ['url' => $url, 'color' => 'error'])
Restablecer contraseña
@endcomponent

Este enlace expira en **1 hora**. Si no solicitaste esto, ignora el correo.

— El equipo de STATELESS
@endcomponent