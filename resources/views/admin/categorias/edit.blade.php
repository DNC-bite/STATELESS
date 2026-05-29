@extends('layouts.admin')

@section('page-title', 'CATEGORÍAS')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Editar Categoría</h2>
    <a href="{{ route('categorias.index') }}" class="btn-sl-outline">← Volver</a>
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
    <form action="{{ route('categorias.update', $categoria) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="sl-form-group">
            <label class="sl-label">Nombre</label>
            <input type="text" name="nombre" class="sl-input" value="{{ old('nombre', $categoria->nombre) }}" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Descripción</label>
            <textarea name="descripcion" class="sl-input" rows="4">{{ old('descripcion', $categoria->descripcion) }}</textarea>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Estado</label>
            <select name="estado" class="sl-input">
                <option value="1" {{ $categoria->estado ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$categoria->estado ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn-sl">Actualizar</button>
            <a href="{{ route('categorias.index') }}" class="btn-sl-outline">Cancelar</a>
        </div>
    </form>
</div>

@endsection