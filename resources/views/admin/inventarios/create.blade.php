@extends('layouts.admin')

@section('page-title', 'INVENTARIO')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Registrar Inventario</h2>
    <a href="{{ route('inventarios.index') }}" class="btn-sl-outline">← Volver</a>
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
    <form action="{{ route('inventarios.store') }}" method="POST">
        @csrf
        <div class="sl-form-group">
            <label class="sl-label">Producto</label>
            <select name="producto_id" class="sl-input" required>
                <option value="">Seleccionar...</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                        {{ $producto->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Stock Actual</label>
            <input type="number" name="stock_actual" class="sl-input" value="{{ old('stock_actual') }}" min="0" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Stock Mínimo</label>
            <input type="number" name="stock_minimo" class="sl-input" value="{{ old('stock_minimo') }}" min="0" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Stock Máximo</label>
            <input type="number" name="stock_maximo" class="sl-input" value="{{ old('stock_maximo') }}" min="0" required>
        </div>
        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn-sl">Registrar</button>
            <a href="{{ route('inventarios.index') }}" class="btn-sl-outline">Cancelar</a>
        </div>
    </form>
</div>

@endsection