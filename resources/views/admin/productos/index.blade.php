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

<table class="stateless-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Estado</th>
            <th>Categoría</th>
            <th>Proveedor</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productos as $producto)
        <tr>
            <td>{{ $producto->id }}</td>
            <td>{{ $producto->nombre }}</td>
            <td>{{ Str::limit($producto->descripcion, 30) ?? '—' }}</td>
            <td>${{ number_format($producto->precio, 2) }}</td>
            <td>{{ $producto->estado }}</td>
            <td>{{ $producto->categoria->nombre ?? '—' }}</td>
            <td>{{ $producto->proveedor->nombre ?? '—' }}</td>
            <td>{{ $producto->inventario->stock_actual ?? '—' }}</td>
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
            <td colspan="9" style="text-align:center; opacity:0.5; padding:40px;">No hay productos registrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection