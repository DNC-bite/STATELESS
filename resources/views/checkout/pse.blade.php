@extends('layouts.app')

@section('content')
<section style="padding: 60px; max-width: 500px; margin: 0 auto;">

    <div style="background:#0066cc; color:#fff; padding:20px 24px; margin-bottom:32px; display:flex; align-items:center; gap:16px;">
        <p style="font-size:24px;">🏦</p>
        <div>
            <p style="font-family:'Bebas Neue', sans-serif; font-size:20px; letter-spacing:2px;">PSE — SIMULACIÓN ACADÉMICA</p>
            <p style="font-size:11px; opacity:0.8; letter-spacing:1px;">Proyecto SENA · No es una pasarela real</p>
        </div>
    </div>

    <div style="background:#fff; border:1px solid #eee; padding:32px;">

        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:4px;">Referencia de pago</p>
        <p style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px; margin-bottom:24px;">PSE-{{ str_pad($venta->id, 8, '0', STR_PAD_LEFT) }}</p>

        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:4px;">Monto a pagar</p>
        <p style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:2px; margin-bottom:32px;">${{ number_format($venta->total, 2) }} COP</p>

        <p style="font-size:13px; font-weight:600; margin-bottom:16px;">Selecciona un banco simulado</p>

        <form action="{{ route('checkout.pse.confirmar', $venta->id) }}" method="POST">
            @csrf

            <div style="margin-bottom:16px;">
                <label style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; display:block; margin-bottom:8px;">Banco</label>
                <select name="banco_simulado" style="width:100%; border:1px solid #ddd; padding:12px 16px; font-size:13px;" required>
                    <option value="banco_aprueba">Banco Demo — Aprueba pago</option>
                    <option value="banco_rechaza">Banco Demo — Rechaza pago</option>
                </select>
            </div>

            <button type="submit" style="width:100%; background:#0066cc; color:#fff; border:none; padding:16px; font-size:13px; font-weight:600; letter-spacing:2px; text-transform:uppercase; cursor:pointer;">
                Simular Confirmación
            </button>
        </form>

        <p style="font-size:11px; opacity:0.5; text-align:center; margin-top:16px;">
            Esta pantalla no se conecta a ningún banco. Es una simulación para el proyecto académico STATELESS (SENA).
        </p>
    </div>

</section>
@endsection