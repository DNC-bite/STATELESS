@extends('layouts.admin')

@section('page-title', 'REPORTES — PROVEEDORES')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Reporte de Proveedores</h2>
    <a href="{{ route('reportes.index') }}" class="btn-sl-outline">← Volver</a>
</div>

<!-- STATS -->
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:32px;">
    <div class="stat-card">
        <div class="stat-label">Total Proveedores</div>
        <div class="stat-value">{{ $totalProveedores }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Activos</div>
        <div class="stat-value" style="color:green;">{{ $activos }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Inactivos</div>
        <div class="stat-value" style="color:#c00;">{{ $inactivos }}</div>
    </div>
</div>

<!-- TABLA -->
<div style="background:#fff; border:1px solid #eee; padding:24px;">
    <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:16px;">Detalle de Proveedores</p>
    <table class="stateless-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Productos</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proveedores as $proveedor)
            <tr>
                <td>{{ $proveedor->id }}</td>
                <td>{{ $proveedor->nombre }}</td>
                <td>{{ $proveedor->telefono }}</td>
                <td>{{ $proveedor->correo }}</td>
                <td>{{ $proveedor->productos->count() }}</td>
                <td>
                    @if($proveedor->estado)
                        <span style="background:green; color:#fff; padding:2px 8px; font-size:10px;">ACTIVO</span>
                    @else
                        <span style="background:#c00; color:#fff; padding:2px 8px; font-size:10px;">INACTIVO</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; opacity:0.4; padding:20px;">No hay proveedores.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection