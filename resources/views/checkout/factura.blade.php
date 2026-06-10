@extends('layouts.app')

@section('content')
<section style="padding: 60px; max-width: 800px; margin: 0 auto;">

    <!-- ENCABEZADO -->
    <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:40px; padding-bottom:24px; border-bottom:2px solid #000;">
        <div>
            <h1 style="font-family:'Bebas Neue', sans-serif; font-size:48px; letter-spacing:4px; margin-bottom:4px;">STATELESS</h1>
            <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4;">Factura Electrónica</p>
        </div>
        <div style="text-align:right;">
            <p style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px;">FACTURA #{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p style="font-size:12px; opacity:0.5;">{{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <!-- ÉXITO -->
    <div style="background:#000; color:#fff; padding:20px 24px; margin-bottom:32px;">
        <p style="font-family:'Bebas Neue', sans-serif; font-size:20px; letter-spacing:2px;">✓ PAGO CONFIRMADO</p>
        <p style="font-size:12px; opacity:0.6; margin-top:4px;">Tu pedido ha sido procesado correctamente.</p>
    </div>

    <!-- DATOS CLIENTE -->
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:40px; margin-bottom:32px;">
        <div>
            <p style="font-size:10px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:8px;">Cliente</p>
            <p style="font-size:14px; font-weight:600;">{{ $venta->usuario->name }}</p>
            <p style="font-size:13px; opacity:0.6;">{{ $venta->usuario->email }}</p>
        </div>
        <div>
            <p style="font-size:10px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:8px;">Envío</p>
            <p style="font-size:14px; font-weight:600;">{{ $venta->envio->direccion ?? '—' }}</p>
            <p style="font-size:13px; opacity:0.6;">{{ $venta->envio->ciudad ?? '—' }}</p>
        </div>
    </div>

    <!-- DETALLES VENTA -->
    <div style="margin-bottom:32px;">
        <p style="font-size:10px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:16px;">Detalles</p>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #000;">
                    <th style="text-align:left; padding:10px 0; font-size:11px; letter-spacing:2px; text-transform:uppercase;">Descripción</th>
                    <th style="text-align:right; padding:10px 0; font-size:11px; letter-spacing:2px; text-transform:uppercase;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:14px 0; font-size:13px;">
                        Pedido #{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}<br>
                        <span style="opacity:0.5; font-size:12px;">{{ ucfirst($venta->tipo_venta) }} — {{ ucfirst($venta->metodo_pago) }}</span>
                    </td>
                    <td style="padding:14px 0; font-size:13px; text-align:right; font-weight:600;">${{ number_format($venta->total, 2) }}</td>
                </tr>
            </tbody>
            <!-- Código Efecty -->
@if($venta->metodo_pago === 'efecty' && $venta->codigo_pago)
<div style="background:#fff3cd; border:1px solid #ffc107; padding:20px; margin-bottom:24px;">
    <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; margin-bottom:8px;">⚠️ PENDIENTE DE PAGO</p>
    <p style="font-size:13px; margin-bottom:12px;">Tu pedido está reservado. Tienes <strong>48 horas</strong> para realizar el pago en cualquier punto Efecty.</p>
    <div style="background:#000; color:#fff; padding:16px; text-align:center;">
        <p style="font-size:11px; letter-spacing:2px; opacity:0.6; margin-bottom:4px;">TU CÓDIGO DE PAGO</p>
        <p style="font-family:'Bebas Neue', sans-serif; font-size:36px; letter-spacing:6px;">{{ $venta->codigo_pago }}</p>
    </div>
    <p style="font-size:11px; opacity:0.5; margin-top:12px;">Presenta este código en cualquier punto Efecty del país.</p>
</div>
@endif

<!-- PSE -->
@if($venta->metodo_pago === 'pse')
<div style="background:#e8f4fd; border:1px solid #0066cc; padding:20px; margin-bottom:24px;">
    <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; margin-bottom:8px;">🏦 PAGO PSE</p>
    <p style="font-size:13px; margin-bottom:8px;">Tu pago está siendo procesado a través de PSE.</p>
    <p style="font-size:12px; opacity:0.6;">Referencia: <strong>PSE-{{ str_pad($venta->id, 8, '0', STR_PAD_LEFT) }}</strong></p>
    <p style="font-size:11px; opacity:0.5; margin-top:8px;">Recibirás una confirmación por correo electrónico.</p>
</div>
@endif

<!-- Nequi -->
@if($venta->metodo_pago === 'nequi')
<div style="background:#f0f0ff; border:1px solid #6600cc; padding:20px; margin-bottom:24px;">
    <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; margin-bottom:8px;">📱 PAGO NEQUI</p>
    <p style="font-size:13px; margin-bottom:8px;">Tu pago está siendo procesado a través de Nequi.</p>
    <p style="font-size:12px; opacity:0.6;">Referencia: <strong>NEQ-{{ str_pad($venta->id, 8, '0', STR_PAD_LEFT) }}</strong></p>
    <p style="font-size:11px; opacity:0.5; margin-top:8px;">Revisa las notificaciones en tu app Nequi.</p>
</div>
@endif
            <tfoot>
                <tr>
                    <td style="padding:16px 0; font-family:'Bebas Neue', sans-serif; font-size:20px; letter-spacing:2px;">TOTAL</td>
                    <td style="padding:16px 0; font-family:'Bebas Neue', sans-serif; font-size:20px; text-align:right;">${{ number_format($venta->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- ACCIONES -->
    <div style="display:flex; gap:16px; padding-top:24px; border-top:1px solid #eee;">
        <a href="{{ route('checkout.descargar', $venta->id) }}" class="btn-stateless">Descargar PDF</a>
        <a href="{{ url('/') }}" class="btn-stateless-outline">Seguir comprando</a>
    </div>

</section>
@endsection