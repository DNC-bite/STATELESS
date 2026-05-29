@extends('layouts.admin')

@section('page-title', 'ENVÍOS')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Editar Envío</h2>
    <a href="{{ route('envios.index') }}" class="btn-sl-outline">← Volver</a>
</div>

@if($errors->any())
    <div style="background:#fff0f0; border:1px solid #c00; padding:12px 20px; margin-bottom:24px; font-size:13px;">
        <ul style="margin:0; padding-left:16px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="background:#fff; border:1px solid #eee; padding:32px; max-width:600px;">
    <form action="{{ route('envios.update', $envio) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="sl-form-group">
            <label class="sl-label">Venta</label>
            <select name="venta_id" class="sl-input" required>
                <option value="">Seleccionar...</option>
                @foreach($ventas as $venta)
                    <option value="{{ $venta->id }}" {{ $envio->venta_id == $venta->id ? 'selected' : '' }}>
                        #{{ $venta->id }} — ${{ number_format($venta->total, 2) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Fecha de Envío</label>
            <input type="date" name="fecha_envio" class="sl-input" value="{{ old('fecha_envio', $envio->fecha_envio ? \Carbon\Carbon::parse($envio->fecha_envio)->format('Y-m-d') : '') }}">
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Dirección</label>
            <input type="text" name="direccion" class="sl-input" value="{{ old('direccion', $envio->direccion) }}" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Ciudad</label>
            <input type="text" name="ciudad" class="sl-input" value="{{ old('ciudad', $envio->ciudad) }}" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Estado</label>
            <select name="estado" class="sl-input" required>
                <option value="pendiente" {{ $envio->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en_curso" {{ $envio->estado == 'en_curso' ? 'selected' : '' }}>En Curso</option>
                <option value="entregado" {{ $envio->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
            </select>
        </div>
        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn-sl">Actualizar</button>
            <a href="{{ route('envios.index') }}" class="btn-sl-outline">Cancelar</a>
        </div>
    </form>
</div>

@endsection