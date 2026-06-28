@extends('layouts.admin')

@section('page-title', 'ENVÍOS')

@section('content')

@if(session('success'))
    <div class="alert-success-sl">{{ session('success') }}</div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Lista de Envíos</h2>
    <a href="{{ route('envios.create') }}" class="btn-sl">+ Registrar</a>
</div>

<!-- STATS -->
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:32px;">
    <div class="stat-card">
        <div class="stat-label">Total Envíos</div>
        <div class="stat-value">{{ $totalEnvios }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pendientes</div>
        <div class="stat-value">{{ $enviosPendientes }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">En Curso</div>
        <div class="stat-value">{{ $enviosEnCurso }}</div>
    </div>
</div>

<table class="stateless-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha Envío</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Estado</th>
            <th>ID Venta</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @forelse($envios as $envio)
        <tr>
            <td>{{ $envio->id }}</td>
            <td>{{ $envio->fecha_envio ? \Carbon\Carbon::parse($envio->fecha_envio)->format('d/m/Y') : '—' }}</td>
            <td>{{ $envio->direccion }}</td>
            <td>{{ $envio->ciudad }}</td>
            <td>{{ ucfirst($envio->estado) }}</td>
            <td>{{ $envio->venta_id }}</td>
            <td>
            <form action="{{ route('envios.update', $envio) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="estado" class="sl-input" style="font-size:11px; padding:6px;" onchange="this.form.submit()">
                    <option value="pendiente" {{ $envio->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="empacando" {{ $envio->estado == 'empacando' ? 'selected' : '' }}>Empacando</option>
                    <option value="en_transporte" {{ $envio->estado == 'en_transporte' ? 'selected' : '' }}>En transporte</option>
                    <option value="en_curso" {{ $envio->estado == 'en_curso' ? 'selected' : '' }}>Enviado</option>
                    <option value="entregado" {{ $envio->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                </select>
            </form>
        </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center; opacity:0.5; padding:40px;">No hay envíos registrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection