@extends('layouts.admin')

@section('page-title', 'PROVEEDORES')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Editar Proveedor</h2>
    <a href="{{ route('proveedores.index') }}" class="btn-sl-outline">← Volver</a>
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
    <form action="{{ route('proveedores.update', $proveedor) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="sl-form-group">
            <label class="sl-label">Nombre</label>
            <input type="text" name="nombre" class="sl-input" value="{{ old('nombre', $proveedor->nombre) }}" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Teléfono</label>
            <input type="text" name="telefono" class="sl-input" value="{{ old('telefono', $proveedor->telefono) }}" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Correo</label>
            <input type="email" name="correo" class="sl-input" value="{{ old('correo', $proveedor->correo) }}" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Estado</label>
            <select name="estado" class="sl-input">
                <option value="1" {{ $proveedor->estado ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$proveedor->estado ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn-sl">Actualizar</button>
            <a href="{{ route('proveedores.index') }}" class="btn-sl-outline">Cancelar</a>
        </div>
    </form>
</div>

@endsection