@extends('layouts.app')

@section('content')

<!-- DETALLE PRODUCTO -->
<section style="padding: 80px 60px; max-width:1200px; margin:0 auto;">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:start;">

        <!-- CARRUSEL DE IMÁGENES -->
        <div style="position:relative; overflow:hidden;">
            <div id="producto-carousel" style="display:flex; transition:transform 0.4s ease;">
                
                <!-- Imagen principal -->
                <div style="min-width:100%; flex-shrink:0;">
                    @if($producto->imagen)
                        <img src="{{ asset('images/' . $producto->imagen) }}"
                             style="width:100%; height:600px; object-fit:cover; object-position:center; display:block;">
                    @else
                        <div style="background:#f2f2f2; width:100%; height:600px;"></div>
                    @endif
                </div>

                <!-- Imágenes adicionales -->
                @foreach($producto->imagenes as $img)
                <div style="min-width:100%; flex-shrink:0;">
                    <img src="{{ asset('images/' . $img->imagen) }}"
                         style="width:100%; height:600px; object-fit:cover; object-position:center; display:block;">
                </div>
                @endforeach
            </div>

            <!-- Botones laterales -->
            @if($producto->imagenes->count() > 0)
            <button onclick="moverProducto(-1)" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); background:rgba(0,0,0,0.5); color:#fff; border:none; width:40px; height:40px; font-size:20px; cursor:pointer;">‹</button>
            <button onclick="moverProducto(1)" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:rgba(0,0,0,0.5); color:#fff; border:none; width:40px; height:40px; font-size:20px; cursor:pointer;">›</button>
            @endif

            <!-- Miniaturas -->
            @if($producto->imagenes->count() > 0)
            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:12px;">
                <div onclick="irAImagenProducto(0)"
                     id="thumb-0"
                     style="width:72px; height:72px; cursor:pointer; border:2px solid #000; overflow:hidden; flex-shrink:0;">
                    @if($producto->imagen)
                        <img src="{{ asset('images/' . $producto->imagen) }}"
                             style="width:100%; height:100%; object-fit:cover;">
                    @endif
                </div>
                @foreach($producto->imagenes as $i => $img)
                <div onclick="irAImagenProducto({{ $i + 1 }})"
                     id="thumb-{{ $i + 1 }}"
                     style="width:72px; height:72px; cursor:pointer; border:2px solid #ddd; overflow:hidden; flex-shrink:0;">
                    <img src="{{ asset('images/' . $img->imagen) }}"
                         style="width:100%; height:100%; object-fit:cover;">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- INFO -->
        <div>
            <p style="font-size:11px; letter-spacing:3px; text-transform:uppercase; opacity:0.4; margin-bottom:12px;">{{ $producto->categoria->nombre ?? '' }}</p>
            <h1 style="font-family:'Bebas Neue', sans-serif; font-size:56px; letter-spacing:4px; margin-bottom:16px;">{{ $producto->nombre }}</h1>
            <p style="font-family:'Bebas Neue', sans-serif; font-size:36px; letter-spacing:2px; margin-bottom:24px;">${{ number_format($producto->precio, 2) }}</p>
            <p style="font-size:14px; line-height:1.8; opacity:0.7; margin-bottom:32px;">{{ $producto->descripcion }}</p>

            {{-- VARIANTES DE COLOR --}}
            @if($producto->variantes->count() > 0)
            <div style="margin-bottom:32px;">
                <p style="font-size:11px; letter-spacing:3px; text-transform:uppercase; opacity:0.4; margin-bottom:12px;">
                    Color: <span id="color-nombre" style="color:#000; opacity:1; font-weight:600;">Original</span>
                </p>
                <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                    
                    {{-- Círculo original --}}
                    <button
                        onclick="seleccionarOriginal()"
                        title="Original"
                        id="btn-variante-original"
                        style="
                            width:36px; height:36px;
                            border-radius:50%;
                            background: url('/images/{{ $producto->imagen }}') center/cover;
                            border: 3px solid #000;
                            cursor:pointer;
                            padding:0;
                            flex-shrink:0;
                        "
                    ></button>

                    {{-- Círculos de variantes --}}
                    @foreach($producto->variantes as $i => $variante)
                    <button
                        onclick="seleccionarVariante({{ $variante->id }}, '{{ $variante->color }}', '{{ $variante->imagen }}', {{ $variante->stock_actual }})"
                        title="{{ $variante->color }}"
                        id="btn-variante-{{ $variante->id }}"
                        style="
                            width:36px; height:36px;
                            border-radius:50%;
                            background:{{ $variante->hex ?? '#ccc' }};
                            border: 2px solid #ddd;
                            cursor:pointer;
                            padding:0;
                            flex-shrink:0;
                        "
                    ></button>
                    @endforeach
                </div>

                <p id="variante-stock" style="font-size:12px; opacity:0.5; margin-top:10px; letter-spacing:1px;">
                    Stock: {{ $producto->stock_actual }} unidades
                </p>
            </div>
            @endif

            {{-- BOTÓN CARRITO --}}
            @if(Auth::check())
                <button id="btn-carrito"
                        onclick="agregarAlCarritoShow({{ $producto->id }}, this)"
                        class="btn-stateless"
                        style="width:100%; padding:16px; font-size:13px;">
                    Añadir al carrito
                </button>
            @else
                <a href="{{ route('login') }}" class="btn-stateless"
                   style="width:100%; padding:16px; font-size:13px; text-align:center; display:block;">
                    Iniciar sesión para comprar
                </a>
            @endif

            {{-- Stock general (si no hay variantes) --}}
            @if($producto->variantes->count() === 0)
            <div style="margin-top:32px; padding-top:24px; border-top:1px solid #eee;">
                <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:8px;">Stock disponible</p>
                <p style="font-size:14px; font-weight:600;">{{ $producto->stock_actual }} unidades</p>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- PRODUCTOS RELACIONADOS -->
@if($relacionados->count() > 0)
<section style="padding: 60px; border-top:1px solid #eee;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:36px; letter-spacing:4px; margin-bottom:32px;">MISMO ESTILO</h2>
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:30px;">
        @foreach($relacionados as $rel)
        <div>
            <a href="{{ route('producto.show', $rel) }}" style="text-decoration:none; color:#000;">
                @if($rel->imagen)
                    <img src="{{ asset('images/' . $rel->imagen) }}"
                         style="width:100%; aspect-ratio:3/4; object-fit:cover; margin-bottom:16px;">
                @else
                    <div style="background:#f2f2f2; aspect-ratio:3/4; margin-bottom:16px;"></div>
                @endif
                <p style="font-size:13px; font-weight:600; letter-spacing:1px; text-transform:uppercase;">{{ $rel->nombre }}</p>
                <p style="font-size:13px; opacity:0.5;">${{ number_format($rel->precio, 2) }}</p>
            </a>
        </div>
        @endforeach
    </div>
</section>
@endif

<script>
let productoIndex = 0;
const totalImagenes = {{ $producto->imagenes->count() + 1 }};
const imagenOriginal = '/images/{{ $producto->imagen }}';

function moverProducto(dir) {
    productoIndex = (productoIndex + dir + totalImagenes) % totalImagenes;
    actualizarProductoCarrusel();
}

function irAImagenProducto(index) {
    productoIndex = index;
    actualizarProductoCarrusel();
}

function actualizarProductoCarrusel() {
    document.getElementById('producto-carousel').style.transform =
        `translateX(-${productoIndex * 100}%)`;

    for (let i = 0; i < totalImagenes; i++) {
        const thumb = document.getElementById('thumb-' + i);
        if (thumb) {
            thumb.style.border = i === productoIndex ? '2px solid #000' : '2px solid #ddd';
        }
    }
}

function seleccionarOriginal() {
    // Restaurar imagen principal
    const firstSlide = document.getElementById('producto-carousel').querySelector('div');
    if (firstSlide) {
        firstSlide.innerHTML = `<img src="${imagenOriginal}" style="width:100%; height:600px; object-fit:cover; object-position:center; display:block;">`;
    }
    const thumb0 = document.getElementById('thumb-0');
    if (thumb0) {
        thumb0.innerHTML = `<img src="${imagenOriginal}" style="width:100%; height:100%; object-fit:cover;">`;
    }
    productoIndex = 0;
    actualizarProductoCarrusel();

    document.getElementById('color-nombre').textContent = 'Original';
    document.getElementById('variante-stock').textContent = 'Stock: {{ $producto->stock_actual }} unidades';

    document.querySelectorAll('[id^="btn-variante-"]').forEach(b => b.style.border = '2px solid #ddd');
    document.getElementById('btn-variante-original').style.border = '3px solid #000';
}

function seleccionarVariante(id, color, imagen, stock) {
    document.getElementById('color-nombre').textContent = color;
    document.getElementById('variante-stock').textContent = 'Stock: ' + stock + ' unidades';

    if (imagen) {
        const firstSlide = document.getElementById('producto-carousel').querySelector('div');
        if (firstSlide) {
            firstSlide.innerHTML = `<img src="/images/${imagen}" style="width:100%; height:600px; object-fit:cover; object-position:center; display:block;">`;
        }
        const thumb0 = document.getElementById('thumb-0');
        if (thumb0) {
            thumb0.innerHTML = `<img src="/images/${imagen}" style="width:100%; height:100%; object-fit:cover;">`;
        }
        productoIndex = 0;
        actualizarProductoCarrusel();
    }

    const btn = document.getElementById('btn-carrito');
    if (btn) {
        if (stock <= 0) {
            btn.disabled = true;
            btn.textContent = 'Agotado';
            btn.style.opacity = '0.4';
        } else {
            btn.disabled = false;
            btn.textContent = 'Añadir al carrito';
            btn.style.opacity = '1';
        }
    }

    document.querySelectorAll('[id^="btn-variante-"]').forEach(b => b.style.border = '2px solid #ddd');
    document.getElementById('btn-variante-' + id).style.border = '3px solid #000';
}

function agregarAlCarritoShow(productoId, btn) {
    btn.disabled = true;
    btn.textContent = 'Agregando...';
    fetch(`/carrito/agregar/${productoId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            btn.textContent = '✓ Agregado';
            let contador = document.getElementById('carrito-contador');
            if (contador) {
                contador.textContent = data.cantidad;
                contador.style.display = 'flex';
            }
        } else {
            btn.textContent = data.mensaje;
            btn.style.opacity = '0.5';
        }
        setTimeout(() => {
            btn.disabled = false;
            btn.textContent = 'Añadir al carrito';
            btn.style.opacity = '1';
        }, 2000);
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = 'Añadir al carrito';
    });
}
</script>

@endsection