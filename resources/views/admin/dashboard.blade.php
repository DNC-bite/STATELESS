@extends('layouts.admin')

@section('page-title', 'DASHBOARD')

@section('content')

<!-- STATS CARDS -->
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:32px;">
    <div class="stat-card">
        <div class="stat-label">Ventas Totales</div>
        <div class="stat-value">${{ number_format($totalVentas, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Pedidos</div>
        <div class="stat-value">{{ $totalPedidos }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Clientes</div>
        <div class="stat-value">{{ $totalClientes }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Productos</div>
        <div class="stat-value">{{ $totalProductos }}</div>
    </div>
</div>

<!-- ALERTAS -->
@if($stockBajo > 0 || $enviosPendientes > 0)
<div style="display:flex; gap:16px; margin-bottom:32px;">
    @if($stockBajo > 0)
    <div style="background:#fff3cd; border:1px solid #ffc107; padding:16px 20px; flex:1;">
        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600;">⚠️ Stock Bajo</p>
        <p style="font-size:13px; margin-top:4px;">{{ $stockBajo }} producto(s) con stock bajo o agotado</p>
        <a href="{{ route('productos.index', ['filtro' => 'stock_bajo']) }}" style="font-size:11px; letter-spacing:1px; text-transform:uppercase; color:#000; text-decoration:none; border-bottom:1px solid #000; margin-top:8px; display:inline-block;">Ver productos</a>
    </div>
    @endif
    @if($enviosPendientes > 0)
    <div style="background:#e8f4fd; border:1px solid #0066cc; padding:16px 20px; flex:1;">
        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600;">📦 Envíos Pendientes</p>
        <p style="font-size:13px; margin-top:4px;">{{ $enviosPendientes }} envío(s) pendientes de despachar</p>
        <a href="{{ route('envios.index') }}" style="font-size:11px; letter-spacing:1px; text-transform:uppercase; color:#000; text-decoration:none; border-bottom:1px solid #000; margin-top:8px; display:inline-block;">Ver envíos</a>
    </div>
    @endif
</div>
@endif

<!-- GRÁFICAS -->
<div style="display:grid; grid-template-columns:2fr 1fr; gap:24px; margin-bottom:32px;">

    <!-- Ventas por mes -->
    <div style="background:#fff; border:1px solid #eee; padding:24px;">
        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:16px;">Ventas último mes</p>
        <canvas id="graficaVentas" height="120"></canvas>
    </div>

    <!-- Métodos de pago -->
    <div style="background:#fff; border:1px solid #eee; padding:24px;">
        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:16px;">Métodos de pago</p>
        <canvas id="graficaMetodos" height="200"></canvas>
    </div>

</div>

<!-- TABLAS -->
<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

    <!-- Ventas recientes -->
    <div style="background:#fff; border:1px solid #eee; padding:24px;">
        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:16px;">Ventas Recientes</p>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #000;">
                    <th style="text-align:left; padding:8px 0; font-size:10px; letter-spacing:1px; text-transform:uppercase;">Cliente</th>
                    <th style="text-align:left; padding:8px 0; font-size:10px; letter-spacing:1px; text-transform:uppercase;">Método</th>
                    <th style="text-align:right; padding:8px 0; font-size:10px; letter-spacing:1px; text-transform:uppercase;">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventasRecientes as $venta)
                <tr style="border-bottom:1px solid #f0f0f0;">
                    <td style="padding:10px 0; font-size:12px;">{{ $venta->usuario->name ?? '—' }}</td>
                    <td style="padding:10px 0; font-size:12px;">{{ ucfirst($venta->metodo_pago) }}</td>
                    <td style="padding:10px 0; font-size:12px; text-align:right;">${{ number_format($venta->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="padding:20px 0; opacity:0.4; font-size:12px;">No hay ventas aún.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Productos más vendidos -->
    <div style="background:#fff; border:1px solid #eee; padding:24px;">
        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:16px;">Productos más vendidos</p>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #000;">
                    <th style="text-align:left; padding:8px 0; font-size:10px; letter-spacing:1px; text-transform:uppercase;">Producto</th>
                    <th style="text-align:right; padding:8px 0; font-size:10px; letter-spacing:1px; text-transform:uppercase;">Vendidos</th>
                    <th style="text-align:right; padding:8px 0; font-size:10px; letter-spacing:1px; text-transform:uppercase;">Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productosMasVendidos as $producto)
                <tr style="border-bottom:1px solid #f0f0f0;">
                    <td style="padding:10px 0; font-size:12px;">{{ $producto->nombre }}</td>
                    <td style="padding:10px 0; font-size:12px; text-align:right;">{{ $producto->total_vendido }}</td>
                    <td style="padding:10px 0; font-size:12px; text-align:right; {{ $producto->stock_actual <= $producto->stock_minimo ? 'color:#c00;' : '' }}">{{ $producto->stock_actual }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="padding:20px 0; opacity:0.4; font-size:12px;">No hay datos aún.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfica ventas último mes
const ctxVentas = document.getElementById('graficaVentas').getContext('2d');
new Chart(ctxVentas, {
    type: 'bar',
    data: {
        labels: {!! json_encode($labelsDias) !!},
        datasets: [{
            label: 'Ventas COP',
            data: {!! json_encode($ventasPorDia) !!},
            backgroundColor: '#000',
            borderRadius: 2,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
            x: { grid: { display: false }, ticks: { maxTicksLimit: 10 } }
        }
    }
});

// Gráfica métodos de pago
const ctxMetodos = document.getElementById('graficaMetodos').getContext('2d');
new Chart(ctxMetodos, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($ventasPorMetodo->pluck('metodo_pago')->map(fn($m) => ucfirst($m))->toArray()) !!},
        datasets: [{
            data: {!! json_encode($ventasPorMetodo->pluck('total')->toArray()) !!},
            backgroundColor: ['#FFFF00', '#CA0080', '#00a2e8', '#ff0000'],
        }]
    },
    options: {
        responsive: true,
        animation: {
            animateRotate: true,
            animateScale: true,
            duration: 1000,
        },
        plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
    }
});
</script>

@endsection