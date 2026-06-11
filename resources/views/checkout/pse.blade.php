@extends('layouts.app')

@section('content')
<section style="padding: 60px; max-width: 500px; margin: 0 auto;">

    <!-- Header banco simulado -->
    <div style="background:#0066cc; color:#fff; padding:20px 24px; margin-bottom:32px; display:flex; align-items:center; gap:16px;">
        <p style="font-size:24px;">🏦</p>
        <div>
            <p style="font-family:'Bebas Neue', sans-serif; font-size:20px; letter-spacing:2px;">PORTAL BANCARIO PSE</p>
            <p style="font-size:11px; opacity:0.7; letter-spacing:1px;">Conexión segura — SSL</p>
        </div>
    </div>

    <div style="background:#fff; border:1px solid #eee; padding:32px;">

        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:4px;">Referencia de pago</p>
        <p style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px; margin-bottom:24px;">PSE-{{ str_pad($venta->id, 8, '0', STR_PAD_LEFT) }}</p>

        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:4px;">Monto a pagar</p>
        <p style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:2px; margin-bottom:32px;">${{ number_format($venta->total, 2) }} COP</p>

        <p style="font-size:13px; font-weight:600; margin-bottom:16px;">Ingresa tus credenciales bancarias</p>

        <form action="{{ route('checkout.pse.confirmar', $venta->id) }}" method="POST">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; display:block; margin-bottom:8px;">Usuario</label>
                <input type="text" name="usuario_banco" style="width:100%; border:1px solid #ddd; padding:12px 16px; font-size:13px; outline:none;" required>
            </div>
            <div style="margin-bottom:24px;">
                <label style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; display:block; margin-bottom:8px;">Contraseña</label>
                <input type="password" name="password_banco" style="width:100%; border:1px solid #ddd; padding:12px 16px; font-size:13px; outline:none;" required>
            </div>

            <button type="submit" style="width:100%; background:#0066cc; color:#fff; border:none; padding:16px; font-size:13px; font-weight:600; letter-spacing:2px; text-transform:uppercase; cursor:pointer;">
                Confirmar Pago
            </button>
        </form>

        <p style="font-size:11px; opacity:0.4; text-align:center; margin-top:16px;">🔒 Transacción segura cifrada con SSL</p>
    </div>

    <p style="font-size:11px; opacity:0.3; text-align:center; margin-top:16px; letter-spacing:1px;">ENTORNO DE PRUEBAS — NO INGRESES DATOS REALES</p>

</section>
@endsection