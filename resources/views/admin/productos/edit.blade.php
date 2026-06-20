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
    <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="sl-form-group">
        <label class="sl-label">Nombre de imagen</label>
        <div id="img-preview" style="margin-bottom:12px;">
            <img id="preview-img" src="{{ $producto->imagen ? '/images/'.$producto->imagen : '' }}"
                 style="height:200px; object-fit:cover; border:1px solid #ddd; {{ $producto->imagen ? '' : 'display:none;' }}">
        </div>

        <select name="imagen" id="imagen-select"
            style="width:100%; padding:10px; border:1px solid #ddd; font-family:'Inter',sans-serif; font-size:13px; margin-bottom:6px;"
            onchange="previsualizarImagen(this.value)">
            <option value="">— Seleccionar imagen existente —</option>
            @foreach($imagenes as $img)
                <option value="{{ $img }}" {{ old('imagen', $producto->imagen) == $img ? 'selected' : '' }}>
                    {{ $img }}
                </option>
            @endforeach
        </select>
        <p style="font-size:12px; opacity:0.5; margin-bottom:16px;">Imágenes existentes en /public/images/</p>

        <label class="sl-label">O sube una imagen nueva</label>
        <input type="file" name="imagen_nueva" id="imagen-nueva" class="sl-input" accept="image/*" onchange="previsualizarArchivo(this)">
        <p style="font-size:11px; opacity:0.4; margin-top:6px;">Si subes un archivo, se usará en lugar del seleccionado arriba</p>
    </div>

    <script>
    function previsualizarImagen(nombre) {
        const preview = document.getElementById('img-preview');
        const img = document.getElementById('preview-img');
        if (nombre) {
            img.src = '/images/' + nombre;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    function previsualizarArchivo(input) {
        const preview = document.getElementById('img-preview');
        const img = document.getElementById('preview-img');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
            document.getElementById('imagen-select').value = '';
        }
    }
    </script>
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
            <label class="sl-label">Stock Actual</label>
            <input type="number" name="stock_actual" class="sl-input" value="{{ old('stock_actual', $producto->stock_actual) }}" min="0" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Stock Mínimo</label>
            <input type="number" name="stock_minimo" class="sl-input" value="{{ old('stock_minimo', $producto->stock_minimo) }}" min="0" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Stock Máximo</label>
            <input type="number" name="stock_maximo" class="sl-input" value="{{ old('stock_maximo', $producto->stock_maximo) }}" min="0" required>
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