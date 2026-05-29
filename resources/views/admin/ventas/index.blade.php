@extends('layouts.admin')

@section('page-title', 'VENTAS')

@section('content')

@if(session('success'))
    <div class="alert-success-sl">{{ session('success') }}</div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Lista de Ventas</h2>
    <a href="{{ route('ventas.create') }}" class="btn-sl">+ Registrar</a>
</div>

<!-- STATS -->
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:32px;">
    <div class="stat-card">
        <div class="stat-label">Ventas Totales</div>
        <div class="stat-value">${{ number_format($total, 2) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Ventas Físicas</div>
        <div class="stat-value">${{ number_format($ventasFisicas, 2) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Ventas Online</div>
        <div class="stat-value">${{ number_format($ventasOnline, 2) }}</div>
    </div>
</div>

<table class="stateless-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo de Venta</th>
            <th>Método de Pago</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ventas as $venta)
        <tr>
            <td>{{ $venta->id }}</td>
            <td>{{ ucfirst($venta->tipo_venta) }}</td>
            <td>{{ ucfirst($venta->metodo_pago) }}</td>
            <td>${{ number_format($venta->total, 2) }}</td>
            <td>{{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y') }}</td>
            <td>{{ $venta->usuario->name ?? '—' }}</td>
            <td style="display:flex; gap:8px;">
                <a href="{{ route('ventas.edit', $venta) }}" class="btn-sl-outline">Editar</a>
                <form action="{{ route('ventas.destroy', $venta) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sl-danger" onclick="return confirm('¿Eliminar esta venta?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center; opacity:0.5; padding:40px;">No hay ventas registradas.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection