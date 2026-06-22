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
<!-- VARIANTES DE COLOR -->
<div style="background:#fff; border:1px solid #eee; padding:32px; max-width:600px; margin-top:24px;">
    <h3 style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:3px; margin-bottom:24px;">
        VARIANTES DE COLOR
    </h3>

    {{-- Variantes existentes --}}
    @foreach($producto->variantes as $variante)
    <div style="display:flex; align-items:center; gap:12px; padding:12px; border:1px solid #eee; margin-bottom:12px;">
        
        {{-- Preview color --}}
        <div style="width:32px; height:32px; border-radius:50%; background:{{ $variante->hex ?? '#ccc' }}; border:1px solid #ddd; flex-shrink:0;"></div>
        
        {{-- Info --}}
        <div style="flex:1;">
            <p style="font-size:13px; font-weight:600; margin:0;">{{ $variante->color }}</p>
            <p style="font-size:12px; opacity:0.5; margin:0;">Stock: {{ $variante->stock_actual }} — {{ $variante->imagen ?? 'Sin imagen' }}</p>
        </div>

        {{-- Eliminar --}}
        <form action="{{ route('variantes.destroy', $variante) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-sl-danger" onclick="return confirm('¿Eliminar esta variante?')"
                    style="font-size:11px; padding:6px 12px;">
                Eliminar
            </button>
        </form>
    </div>
    @endforeach

    @if($producto->variantes->count() === 0)
        <p style="opacity:0.4; font-size:13px; margin-bottom:24px;">No hay variantes registradas.</p>
    @endif

    {{-- Agregar nueva variante --}}
    <div style="border-top:1px solid #eee; padding-top:24px; margin-top:8px;">
        <h4 style="font-size:13px; letter-spacing:2px; text-transform:uppercase; margin-bottom:16px;">Agregar variante</h4>
        <form action="{{ route('variantes.store', $producto) }}" method="POST">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label class="sl-label">Color (nombre)</label>
                    <input type="text" name="color" class="sl-input" placeholder="ej: Negro" required>
                </div>
                <div>
                    <label class="sl-label">Color (hex)</label>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <input type="color" name="hex" value="#000000"
                               style="width:48px; height:40px; border:1px solid #ddd; cursor:pointer; padding:2px;">
                        <span style="font-size:12px; opacity:0.5;">Selecciona el color</span>
                    </div>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                <div>
                    <label class="sl-label">Stock</label>
                    <input type="number" name="stock_actual" class="sl-input" value="0" min="0" required>
                </div>
                <div>
                    <label class="sl-label">Imagen</label>
                    <select name="imagen" class="sl-input">
                        <option value="">— Sin imagen —</option>
                        @foreach($imagenes as $img)
                            <option value="{{ $img }}">{{ $img }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-sl">+ Agregar variante</button>
        </form>
    </div>
</div>
@endsection