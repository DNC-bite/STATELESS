@extends('layouts.admin')

@section('page-title', 'REPORTES — INVENTARIO')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Reporte de Inventario</h2>
    <a href="{{ route('reportes.index') }}" class="btn-sl-outline">← Volver</a>
</div>

<!-- STATS -->
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:32px;">
    <div class="stat-card">
        <div class="stat-label">Total Productos</div>
        <div class="stat-value">{{ $totalProductos }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Stock Bajo</div>
        <div class="stat-value" style="color:#c00;">{{ $stockBajo }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Sin Stock</div>
        <div class="stat-value" style="color:#c00;">{{ $sinStock }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Valor Inventario</div>
        <div class="stat-value" style="font-size:24px;">${{ number_format($valorInventario, 0, ',', '.') }}</div>
    </div>
</div>

<!-- TABLA -->
<div style="background:#fff; border:1px solid #eee; padding:24px;">
    <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:16px;">Estado del Inventario</p>
    <table class="stateless-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock Actual</th>
                <th>Stock Mín</th>
                <th>Stock Máx</th>
                <th>Valor</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
            <tr>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->categoria->nombre ?? '—' }}</td>
                <td>${{ number_format($producto->precio, 0, ',', '.') }}</td>
                @if($producto->stock_actual == 0)
                    <td style="color:#c00; font-weight:600;">{{ $producto->stock_actual }} ⚠️</td>
                @elseif($producto->stock_actual <= $producto->stock_minimo)
                    <td style="color:#f90; font-weight:600;">{{ $producto->stock_actual }} ⚠️</td>
                @else
                    <td style="color:green;">{{ $producto->stock_actual }}</td>
                @endif
                <td>{{ $producto->stock_minimo }}</td>
                <td>{{ $producto->stock_maximo }}</td>
                <td>${{ number_format($producto->precio * $producto->stock_actual, 0, ',', '.') }}</td>
                <td>
                    @if($producto->stock_actual == 0)
                        <span style="background:#c00; color:#fff; padding:2px 8px; font-size:10px;">AGOTADO</span>
                    @elseif($producto->stock_actual <= $producto->stock_minimo)
                        <span style="background:#f90; color:#000; padding:2px 8px; font-size:10px;">STOCK BAJO</span>
                    @else
                        <span style="background:green; color:#fff; padding:2px 8px; font-size:10px;">OK</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; opacity:0.4; padding:20px;">No hay productos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection