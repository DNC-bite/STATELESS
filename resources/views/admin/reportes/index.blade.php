@extends('layouts.admin')

@section('page-title', 'REPORTES')

@section('content')

<h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px; margin-bottom:32px;">Módulo de Reportes</h2>

<div style="display:grid; grid-template-columns:repeat(2,1fr); gap:20px;">

    <a href="{{ route('reportes.ventas') }}" style="text-decoration:none; color:#000;">
        <div style="background:#fff; border:1px solid #eee; padding:32px; transition:border-color 0.2s;" onmouseover="this.style.borderColor='#000'" onmouseout="this.style.borderColor='#eee'">
            <p style="font-size:32px; margin-bottom:12px;">📊</p>
            <p style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px; margin-bottom:8px;">Ventas</p>
            <p style="font-size:13px; opacity:0.5;">Reporte de ventas por período, método de pago y tipo.</p>
        </div>
    </a>

    <a href="{{ route('reportes.inventario') }}" style="text-decoration:none; color:#000;">
        <div style="background:#fff; border:1px solid #eee; padding:32px; transition:border-color 0.2s;" onmouseover="this.style.borderColor='#000'" onmouseout="this.style.borderColor='#eee'">
            <p style="font-size:32px; margin-bottom:12px;">📦</p>
            <p style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px; margin-bottom:8px;">Inventario</p>
            <p style="font-size:13px; opacity:0.5;">Estado del stock, productos bajo mínimo y valor del inventario.</p>
        </div>
    </a>

    <a href="{{ route('reportes.envios') }}" style="text-decoration:none; color:#000;">
        <div style="background:#fff; border:1px solid #eee; padding:32px; transition:border-color 0.2s;" onmouseover="this.style.borderColor='#000'" onmouseout="this.style.borderColor='#eee'">
            <p style="font-size:32px; margin-bottom:12px;">🚚</p>
            <p style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px; margin-bottom:8px;">Envíos</p>
            <p style="font-size:13px; opacity:0.5;">Estado de envíos, pendientes, en curso y entregados.</p>
        </div>
    </a>

    <a href="{{ route('reportes.proveedores') }}" style="text-decoration:none; color:#000;">
        <div style="background:#fff; border:1px solid #eee; padding:32px; transition:border-color 0.2s;" onmouseover="this.style.borderColor='#000'" onmouseout="this.style.borderColor='#eee'">
            <p style="font-size:32px; margin-bottom:12px;">🏭</p>
            <p style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px; margin-bottom:8px;">Proveedores</p>
            <p style="font-size:13px; opacity:0.5;">Lista de proveedores activos, inactivos y sus productos.</p>
        </div>
    </a>

</div>

@endsection