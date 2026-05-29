@extends('layouts.admin')

@section('page-title', 'VENTAS')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Registrar Venta</h2>
    <a href="{{ route('ventas.index') }}" class="btn-sl-outline">← Volver</a>
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
    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf
        <div class="sl-form-group">
            <label class="sl-label">Tipo de Venta</label>
            <select name="tipo_venta" class="sl-input" required>
                <option value="">Seleccionar...</option>
                <option value="fisica" {{ old('tipo_venta') == 'fisica' ? 'selected' : '' }}>Física</option>
                <option value="online" {{ old('tipo_venta') == 'online' ? 'selected' : '' }}>Online</option>
            </select>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Método de Pago</label>
            <select name="metodo_pago" class="sl-input" required>
                <option value="">Seleccionar...</option>
                <option value="efectivo" {{ old('metodo_pago') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                <option value="tarjeta" {{ old('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                <option value="transferencia" {{ old('metodo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
            </select>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Total</label>
            <input type="number" name="total" class="sl-input" value="{{ old('total') }}" step="0.01" min="0" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Usuario</label>
            <select name="user_id" class="sl-input" required>
                <option value="">Seleccionar...</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }} — {{ $usuario->email }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn-sl">Registrar</button>
            <a href="{{ route('ventas.index') }}" class="btn-sl-outline">Cancelar</a>
        </div>
    </form>
</div>

@endsection