@extends('layouts.admin')

@section('page-title', 'PRODUCTOS')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Editar Producto</h2>
    <a href="{{ route('productos.index') }}" class="btn-sl-outline">← Volver</a>
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
    <form action="{{ route('productos.update', $producto) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="sl-form-group">
            <label class="sl-label">Nombre</label>
            <input type="text" name="nombre" class="sl-input" value="{{ old('nombre', $producto->nombre) }}" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Descripción</label>
            <textarea name="descripcion" class="sl-input" rows="4">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Precio</label>
            <input type="number" name="precio" class="sl-input" value="{{ old('precio', $producto->precio) }}" step="0.01" min="0" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Estado</label>
            <select name="estado" class="sl-input">
                <option value="activo" {{ $producto->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ $producto->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Categoría</label>
            <select name="categoria_id" class="sl-input" required>
                <option value="">Seleccionar...</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Proveedor</label>
            <select name="proveedor_id" class="sl-input" required>
                <option value="">Seleccionar...</option>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}" {{ $producto->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn-sl">Actualizar</button>
            <a href="{{ route('productos.index') }}" class="btn-sl-outline">Cancelar</a>
        </div>
    </form>
</div>

@endsection