@extends('layouts.app')

@section('content')

<!-- HERO CARRUSEL -->
<section style="position:relative; background:#000; overflow:hidden;">
    <div id="hero-carousel" style="display:flex; transition:transform 0.6s ease; height:90vh;">
        
        <!-- Slide 1 -->
        <div style="min-width:100%; height:90vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:60px; background:#000; color:#fff;">
            <div>
                <p style="font-size:12px; letter-spacing:6px; text-transform:uppercase; opacity:0.5; margin-bottom:20px;">Nueva Colección 2026</p>
                <h1 style="font-family:'Bebas Neue', sans-serif; font-size:120px; letter-spacing:10px; line-height:1; margin-bottom:20px;">STATELESS</h1>
                <p style="font-size:14px; letter-spacing:3px; text-transform:uppercase; opacity:0.7; margin-bottom:40px;">Define tu mundo. Sin etiquetas.</p>
                <a href="#essentials" class="btn-stateless" style="color:#000; background:#fff; border-color:#fff;">Ver Essentials</a>
            </div>
        </div>

        <!-- Slide 2 -->
        <div style="min-width:100%; height:90vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:60px; background:#111; color:#fff;">
            <div>
               <p style="font-size:12px; letter-spacing:6px; text-transform:uppercase; opacity:0.5; margin-bottom:20px;">Colección</p>
               <h1 style="font-family:'Bebas Neue', sans-serif; font-size:100px; letter-spacing:8px; line-height:1; margin-bottom:20px;">WAVES</h1>
               <p style="font-size:14px; letter-spacing:3px; text-transform:uppercase; opacity:0.7; margin-bottom:40px;">Fluye. Sin resistencia.</p>
               <a href="#waves" class="btn-stateless" style="color:#000; background:#fff; border-color:#fff;">Explorar colección</a>
            </div>
        </div>

        <!-- Slide 3 -->
        <div style="min-width:100%; height:90vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:60px; background:#000; color:#fff;">
            <div>
                <p style="font-size:12px; letter-spacing:6px; text-transform:uppercase; opacity:0.5; margin-bottom:20px;">Colección</p>
                <h1 style="font-family:'Bebas Neue', sans-serif; font-size:100px; letter-spacing:8px; line-height:1; margin-bottom:20px;">OCTANE</h1>
                <p style="font-size:14px; letter-spacing:3px; text-transform:uppercase; opacity:0.7; margin-bottom:40px;">Velocidad, calle y actitud.</p>
                <a href="#octane" class="btn-stateless" style="color:#000; background:#fff; border-color:#fff;">Explorar colección</a>
            </div>
        </div>

    </div>

    <!-- Controles -->
    <button onclick="cambiarSlide(-1)" style="position:absolute; left:24px; top:50%; transform:translateY(-50%); background:none; border:none; color:#fff; font-size:32px; cursor:pointer; opacity:0.6;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.6">‹</button>
    <button onclick="cambiarSlide(1)" style="position:absolute; right:24px; top:50%; transform:translateY(-50%); background:none; border:none; color:#fff; font-size:32px; cursor:pointer; opacity:0.6;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.6">›</button>

    <!-- Dots -->
    <div style="position:absolute; bottom:24px; left:50%; transform:translateX(-50%); display:flex; gap:8px;">
        <span class="dot active" onclick="irASlide(0)" style="width:8px; height:8px; border-radius:50%; background:#fff; cursor:pointer; opacity:1;"></span>
        <span class="dot" onclick="irASlide(1)" style="width:8px; height:8px; border-radius:50%; background:#fff; cursor:pointer; opacity:0.4;"></span>
        <span class="dot" onclick="irASlide(2)" style="width:8px; height:8px; border-radius:50%; background:#fff; cursor:pointer; opacity:0.4;"></span>
    </div>
</section>

<!-- SECCIÓN ESSENTIALS -->
<section id="essentials" style="padding: 80px 40px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:40px;">
        <h2 style="font-family:'Bebas Neue', sans-serif; font-size:48px; letter-spacing:4px;">ESSENTIAL</h2>
        <a href="#" style="font-size:12px; letter-spacing:2px; text-transform:uppercase; color:#000; text-decoration:none; border-bottom:1px solid #000;">Ver todo</a>
    </div>

    <div style="position:relative; overflow:hidden;">
        <div id="essentials-carousel" style="display:flex; gap:16px; transition:transform 0.4s ease;">
            @forelse($essentials as $producto)
            <div style="min-width:calc(33.333% - 11px); flex-shrink:0;">
                <a href="{{ route('producto.show', $producto) }}" style="text-decoration:none; color:#000;">
                    @if($producto->imagen)
                        <img src="{{ asset('images/' . $producto->imagen) }}" style="width:100%; height:500px; object-fit:cover; margin-bottom:16px;">
                    @else
                        <div style="background:#f2f2f2; width:100%; height:500px; margin-bottom:16px;"></div>
                    @endif
                    <p style="font-size:13px; font-weight:600; letter-spacing:1px; text-transform:uppercase;">{{ $producto->nombre }}</p>
                    <p style="font-size:13px; opacity:0.5; margin-bottom:12px;">${{ number_format($producto->precio, 2) }}</p>
                </a>
                @if(Auth::check())
                    <button onclick="agregarAlCarrito(this.dataset.id, this)" data-id="{{ $producto->id }}" class="btn-stateless" style="width:100%; text-align:center;">Añadir al carrito</button>
                @else
                    <a href="{{ route('login') }}" class="btn-stateless" style="width:100%; text-align:center; display:block;">Añadir al carrito</a>
                @endif
            </div>
            @empty
            <p style="opacity:0.4; font-size:13px;">No hay productos disponibles.</p>
            @endforelse
        </div>

        <button onclick="moverEssentials(-1)" style="position:absolute; left:0; top:40%; transform:translateY(-50%); background:#000; color:#fff; border:none; width:40px; height:40px; font-size:20px; cursor:pointer; z-index:10;">‹</button>
        <button onclick="moverEssentials(1)" style="position:absolute; right:0; top:40%; transform:translateY(-50%); background:#000; color:#fff; border:none; width:40px; height:40px; font-size:20px; cursor:pointer; z-index:10;">›</button>
    </div>
</section>

<script>
function agregarAlCarrito(productoId, btn) {
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

// Hero carrusel
let slideActual = 0;
const totalSlides = 3;

function cambiarSlide(direccion) {
    slideActual = (slideActual + direccion + totalSlides) % totalSlides;
    actualizarCarrusel();
}

function irASlide(index) {
    slideActual = index;
    actualizarCarrusel();
}

function actualizarCarrusel() {
    document.getElementById('hero-carousel').style.transform = `translateX(-${slideActual * 100}%)`;
    document.querySelectorAll('.dot').forEach((dot, i) => {
        dot.style.opacity = i === slideActual ? '1' : '0.4';
    });
}

setInterval(() => cambiarSlide(1), 5000);

// Essentials carrusel
let essentialsIndex = 0;
const essentialsTotal = {{ $essentials->count() }};
const visibles = 3;

function moverEssentials(dir) {
    const maxIndex = essentialsTotal - visibles;
    essentialsIndex = essentialsIndex + dir;
    if (essentialsIndex > maxIndex) essentialsIndex = 0;
    if (essentialsIndex < 0) essentialsIndex = maxIndex;
    const carousel = document.getElementById('essentials-carousel');
    const itemWidth = carousel.offsetWidth / visibles;
    carousel.style.transform = `translateX(-${essentialsIndex * itemWidth}px)`;
}

setInterval(() => moverEssentials(1), 4000);
</script>

@endsection