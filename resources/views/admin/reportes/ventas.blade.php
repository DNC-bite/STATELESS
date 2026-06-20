@extends('layouts.admin')

@section('page-title', 'REPORTES — VENTAS')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Reporte de Ventas</h2>
    <a href="{{ route('reportes.index') }}" class="btn-sl-outline">← Volver</a>
</div>

<!-- FILTRO FECHAS -->
<form method="GET" action="{{ route('reportes.ventas') }}" style="background:#fff; border:1px solid #eee; padding:20px; margin-bottom:24px; display:flex; gap:16px; align-items:flex-end;">
    <div>
        <label class="sl-label">Desde</label>
        <input type="date" name="desde" class="sl-input" value="{{ request('desde', $desde->format('Y-m-d')) }}">
    </div>
    <div>
        <label class="sl-label">Hasta</label>
        <input type="date" name="hasta" class="sl-input" value="{{ request('hasta', $hasta->format('Y-m-d')) }}">
    </div>
    <button type="submit" class="btn-sl">Filtrar</button>
</form>

<!-- STATS -->
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:32px;">
    <div class="stat-card">
        <div class="stat-label">Total Ventas</div>
        <div class="stat-value">${{ number_format($totalVentas, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Pedidos</div>
        <div class="stat-value">{{ $totalPedidos }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Ventas Físicas</div>
        <div class="stat-value">${{ number_format($ventasFisicas, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Ventas Online</div>
        <div class="stat-value">${{ number_format($ventasOnline, 0, ',', '.') }}</div>
    </div>
</div>

<!-- POR MÉTODO -->
<div style="background:#fff; border:1px solid #eee; padding:24px; margin-bottom:24px;">
    <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:16px;">Por Método de Pago</p>
    <table class="stateless-table">
        <thead>
            <tr>
                <th>Método</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($porMetodo as $metodo => $datos)
            <tr>
                <td>{{ ucfirst($metodo) }}</td>
                <td>{{ $datos['cantidad'] }}</td>
                <td>${{ number_format($datos['total'], 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="3" style="text-align:center; opacity:0.4; padding:20px;">No hay datos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- LISTA VENTAS -->
<div style="background:#fff; border:1px solid #eee; padding:24px;">
    <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:16px;">Detalle de Ventas</p>
    <table class="stateless-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Tipo</th>
                <th>Método</th>
                <th>Total</th>
                <th>Estado Envío</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ventas as $venta)
            <tr>
                <td>#{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $venta->usuario->name ?? '—' }}</td>
                <td>{{ ucfirst($venta->tipo_venta) }}</td>
                <td>{{ ucfirst($venta->metodo_pago) }}</td>
                <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                <td>{{ ucfirst($venta->envio->estado ?? '—') }}</td>
                <td>{{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; opacity:0.4; padding:20px;">No hay ventas en este período.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection