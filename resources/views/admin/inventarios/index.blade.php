@extends('layouts.admin')

@section('page-title', 'INVENTARIO')

@section('content')

@if(session('success'))
    <div class="alert-success-sl">{{ session('success') }}</div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Lista de Inventario</h2>
    <a href="{{ route('inventarios.create') }}" class="btn-sl">+ Registrar</a>
</div>

<!-- STATS -->
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:32px;">
    <div class="stat-card">
        <div class="stat-label">Total Productos</div>
        <div class="stat-value">{{ $inventarios->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Stock Bajo</div>
        <div class="stat-value">{{ $inventarios->filter(fn($i) => $i->stock_actual <= $i->stock_minimo)->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Última Actualización</div>
        <div class="stat-value" style="font-size:18px;">{{ $inventarios->max('updated_at') ? \Carbon\Carbon::parse($inventarios->max('updated_at'))->format('d/m/Y') : '—' }}</div>
    </div>
</div>

<table class="stateless-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Stock Actual</th>
            <th>Stock Mínimo</th>
            <th>Stock Máximo</th>
            <th>Fecha Actualización</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($inventarios as $inventario)
        <tr>
            <td>{{ $inventario->id }}</td>
            <td>{{ $inventario->producto->nombre ?? '—' }}</td>
            @if($inventario->stock_actual <= $inventario->stock_minimo)
            <td style="color:#c00; font-weight:600;">{{ $inventario->stock_actual }}</td>
        @else
            <td>{{ $inventario->stock_actual }}</td>
        @endif
            <td>{{ $inventario->stock_minimo }}</td>
            <td>{{ $inventario->stock_maximo }}</td>
            <td>{{ \Carbon\Carbon::parse($inventario->updated_at)->format('d/m/Y') }}</td>
            <td style="display:flex; gap:8px;">
                <a href="{{ route('inventarios.edit', $inventario) }}" class="btn-sl-outline">Editar</a>
                <form action="{{ route('inventarios.destroy', $inventario) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sl-danger" onclick="return confirm('¿Eliminar este registro?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center; opacity:0.5; padding:40px;">No hay registros en inventario.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection