@extends('layouts.admin')

@section('page-title', 'REPORTES — ENVÍOS')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Reporte de Envíos</h2>
    <a href="{{ route('reportes.index') }}" class="btn-sl-outline">← Volver</a>
</div>

<!-- STATS -->
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:32px;">
    <div class="stat-card">
        <div class="stat-label">Total Envíos</div>
        <div class="stat-value">{{ $totalEnvios }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pendientes</div>
        <div class="stat-value" style="color:#f90;">{{ $pendientes }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">En Curso</div>
        <div class="stat-value" style="color:#00c;">{{ $enCurso }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Entregados</div>
        <div class="stat-value" style="color:green;">{{ $entregados }}</div>
    </div>
</div>

<!-- TABLA -->
<div style="background:#fff; border:1px solid #eee; padding:24px;">
    <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:16px;">Detalle de Envíos</p>
    <table class="stateless-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Dirección</th>
                <th>Ciudad</th>
                <th>Estado</th>
                <th>Fecha Envío</th>
                <th>ID Venta</th>
            </tr>
        </thead>
        <tbody>
            @forelse($envios as $envio)
            <tr>
                <td>{{ $envio->id }}</td>
                <td>{{ $envio->venta->usuario->name ?? '—' }}</td>
                <td>{{ $envio->direccion }}</td>
                <td>{{ $envio->ciudad }}</td>
                <td>
                    @if($envio->estado == 'entregado')
                        <span style="background:green; color:#fff; padding:2px 8px; font-size:10px;">ENTREGADO</span>
                    @elseif($envio->estado == 'en_curso')
                        <span style="background:#00c; color:#fff; padding:2px 8px; font-size:10px;">EN CURSO</span>
                    @else
                        <span style="background:#f90; color:#000; padding:2px 8px; font-size:10px;">PENDIENTE</span>
                    @endif
                </td>
                <td>{{ $envio->fecha_envio ? \Carbon\Carbon::parse($envio->fecha_envio)->format('d/m/Y') : '—' }}</td>
                <td>#{{ str_pad($envio->venta_id, 6, '0', STR_PAD_LEFT) }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; opacity:0.4; padding:20px;">No hay envíos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection