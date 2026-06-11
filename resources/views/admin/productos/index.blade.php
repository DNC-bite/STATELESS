@extends('layouts.admin')

@section('page-title', 'PRODUCTOS')

@section('content')

@if(session('success'))
    <div class="alert-success-sl">{{ session('success') }}</div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Lista de Productos</h2>
    <a href="{{ route('productos.create') }}" class="btn-sl">+ Registrar</a>
</div>

<!-- STATS -->
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:32px;">
    <div class="stat-card">
        <div class="stat-label">Total Productos</div>
        <div class="stat-value">{{ $productos->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Stock Bajo</div>
        <div class="stat-value">{{ $productos->filter(fn($p) => $p->stock_actual <= $p->stock_minimo)->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Sin Stock</div>
        <div class="stat-value">{{ $productos->where('stock_actual', 0)->count() }}</div>
    </div>
</div>

<table class="stateless-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Estado</th>
            <th>Stock Actual</th>
            <th>Stock Mín</th>
            <th>Stock Máx</th>
            <th>Categoría</th>
            <th>Proveedor</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <!-- FILTROS -->
<div style="display:flex; gap:12px; margin-bottom:24px;">
    <a href="{{ route('productos.index') }}" class="{{ !request('filtro') ? 'btn-sl' : 'btn-sl-outline' }}">Todos</a>
    <a href="{{ route('productos.index', ['filtro' => 'stock_bajo']) }}" class="{{ request('filtro') == 'stock_bajo' ? 'btn-sl' : 'btn-sl-outline' }}">Stock Bajo</a>
    <a href="{{ route('productos.index', ['filtro' => 'sin_stock']) }}" class="{{ request('filtro') == 'sin_stock' ? 'btn-sl' : 'btn-sl-outline' }}">Sin Stock</a>
    <a href="{{ route('productos.index', ['filtro' => 'activo']) }}" class="{{ request('filtro') == 'activo' ? 'btn-sl' : 'btn-sl-outline' }}">Activos</a>
    <a href="{{ route('productos.index', ['filtro' => 'inactivo']) }}" class="{{ request('filtro') == 'inactivo' ? 'btn-sl' : 'btn-sl-outline' }}">Inactivos</a>
</div>
    <tbody>
        @forelse($productos as $producto)
        <tr>
            
            <td>{{ $producto->id }}</td>
            <td>
    @if($producto->imagen)
        <img src="{{ asset('images/' . $producto->imagen) }}" style="width:50px; height:60px; object-fit:cover;">
    @else
        <div style="width:50px; height:60px; background:#f2f2f2;"></div>
    @endif
</td>
            <td>{{ $producto->nombre }}</td>
            <td>${{ number_format($producto->precio, 2) }}</td>
            <td>{{ ucfirst($producto->estado) }}</td>
            @if($producto->stock_actual <= $producto->stock_minimo)
                <td style="color:#c00; font-weight:600;">{{ $producto->stock_actual }}</td>
            @else
                <td>{{ $producto->stock_actual }}</td>
            @endif
            <td>{{ $producto->stock_minimo }}</td>
            <td>{{ $producto->stock_maximo }}</td>
            <td>{{ $producto->categoria->nombre ?? '—' }}</td>
            <td>{{ $producto->proveedor->nombre ?? '—' }}</td>
            <td style="display:flex; gap:8px;">
                <a href="{{ route('productos.edit', $producto) }}" class="btn-sl-outline">Editar</a>
                <form action="{{ route('productos.destroy', $producto) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sl-danger" onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="10" style="text-align:center; opacity:0.5; padding:40px;">No hay productos registrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection