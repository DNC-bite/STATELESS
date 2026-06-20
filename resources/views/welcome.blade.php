@extends('layouts.app')

@section('content')

<style>
/* HERO */
.hero-slide {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 60px;
    opacity: 0;
    transition: opacity 0.8s ease;
    pointer-events: none;
}

.hero-slide.active {
    opacity: 1;
    pointer-events: all;
}

.hero-slide .slide-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    transform: scale(1.08);
    transition: transform 6s ease;
    filter: brightness(0.35);
}

.hero-slide.active .slide-bg {
    transform: scale(1);
}

.slide-content {
    position: relative;
    z-index: 2;
}

.slide-tag {
    font-size: 11px;
    letter-spacing: 6px;
    text-transform: uppercase;
    opacity: 0;
    color: rgba(255,255,255,0.5);
    margin-bottom: 20px;
    transform: translateY(20px);
    transition: all 0.6s ease 0.2s;
}

.slide-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(60px, 12vw, 130px);
    letter-spacing: 10px;
    line-height: 0.9;
    margin-bottom: 16px;
    color: #fff;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.7s ease 0.35s;
}

.slide-line {
    width: 0;
    height: 1px;
    background: rgba(255,255,255,0.4);
    margin: 0 auto 20px;
    transition: width 0.8s ease 0.5s;
}

.slide-sub {
    font-size: 12px;
    letter-spacing: 4px;
    text-transform: uppercase;
    opacity: 0;
    color: rgba(255,255,255,0.6);
    margin-bottom: 40px;
    transform: translateY(20px);
    transition: all 0.6s ease 0.55s;
}

.slide-cta {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease 0.7s;
    display: inline-block;
    padding: 14px 40px;
    border: 1px solid rgba(255,255,255,0.8);
    color: #fff;
    text-decoration: none;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 4px;
    text-transform: uppercase;
    transition: all 0.3s, opacity 0.6s ease 0.7s, transform 0.6s ease 0.7s;
}

.slide-cta:hover {
    background: #fff;
    color: #000;
}

.hero-slide.active .slide-tag,
.hero-slide.active .slide-title,
.hero-slide.active .slide-sub,
.hero-slide.active .slide-cta {
    opacity: 1;
    transform: translateY(0);
}

.hero-slide.active .slide-line {
    width: 60px;
}

/* Noise overlay */
.noise-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
    opacity: 0.04;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
    background-size: 200px;
    pointer-events: none;
}

/* Dots */
.hero-dots {
    position: absolute;
    bottom: 32px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
    z-index: 10;
}

.hero-dot {
    width: 24px;
    height: 2px;
    background: rgba(255,255,255,0.3);
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    padding: 0;
}

.hero-dot.active {
    background: #fff;
    width: 40px;
}

/* Controles */
.hero-ctrl {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff;
    width: 48px;
    height: 48px;
    font-size: 20px;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-ctrl:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.6);
}

/* Número slide */
.slide-counter {
    position: absolute;
    bottom: 32px;
    right: 40px;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 13px;
    letter-spacing: 3px;
    color: rgba(255,255,255,0.3);
    z-index: 10;
}

/* ESSENTIALS */
.essentials-section {
    padding: 100px 40px;
    background: #080808;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 56px;
    border-bottom: 1px solid #1a1a1a;
    padding-bottom: 24px;
}

.section-header-left p {
    font-size: 11px;
    letter-spacing: 4px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.25);
    margin-bottom: 8px;
}

.section-header-left h2 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 52px;
    letter-spacing: 4px;
    line-height: 1;
    color: #fff;
}

.section-header-right a {
    font-size: 11px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.35);
    text-decoration: none;
    transition: color 0.3s;
}

.section-header-right a:hover { color: #fff; }

.essentials-track-wrap {
    position: relative;
    overflow: hidden;
}

.essentials-track {
    display: flex;
    gap: 2px;
    transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.essentials-item {
    min-width: calc(33.333% - 2px);
    flex-shrink: 0;
    border: 1px solid #161616;
    background: #0d0d0d;
    transition: border-color 0.3s;
}

.essentials-item:hover {
    border-color: #333;
}

.essentials-img-wrap {
    overflow: hidden;
    position: relative;
}

.essentials-img-wrap img {
    width: 100%;
    height: 480px;
    object-fit: cover;
    transition: transform 0.7s ease;
    display: block;
    filter: brightness(0.9);
}

.essentials-item:hover .essentials-img-wrap img {
    transform: scale(1.04);
    filter: brightness(1);
}

.essentials-img-wrap .item-num {
    position: absolute;
    top: 16px;
    left: 16px;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 12px;
    letter-spacing: 3px;
    color: rgba(255,255,255,0.3);
    z-index: 2;
}

.essentials-item-body {
    padding: 20px 20px 24px;
    position: relative;
}

.essentials-item-body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 20px;
    right: 20px;
    height: 1px;
    background: #1a1a1a;
}

.essentials-item-name {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 22px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #fff;
    margin-bottom: 4px;
    position: relative;
    display: inline-block;
}

.essentials-item-name::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 1px;
    background: #fff;
    transition: width 0.4s ease;
}

.essentials-item:hover .essentials-item-name::after {
    width: 100%;
}

.essentials-item-price {
    font-size: 12px;
    letter-spacing: 3px;
    color: rgba(255,255,255,0.3);
    margin-bottom: 20px;
    font-family: 'Inter', sans-serif;
}

.essentials-item .btn-stateless {
    background: transparent;
    color: rgba(255,255,255,0.6);
    border-color: #222;
    transition: all 0.3s;
}

.essentials-item .btn-stateless:hover {
    background: #fff;
    color: #000;
    border-color: #fff;
}

.essentials-ctrl {
    position: absolute;
    top: 38%;
    transform: translateY(-50%);
    background: #000;
    color: rgba(255,255,255,0.5);
    border: 1px solid #222;
    width: 44px;
    height: 44px;
    font-size: 20px;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.essentials-ctrl:hover {
    color: #fff;
    border-color: #555;
}
</style>

<!-- HERO -->
<section style="position:relative; background:#000; height:90vh; overflow:hidden;">

    <!-- Slide 1 -->
    <div class="hero-slide active">
        <div class="slide-bg" style="background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0d0d0d 100%);"></div>
        <div class="noise-overlay"></div>
        <div class="slide-content">
            <p class="slide-tag">Nueva Colección 2026</p>
            <h1 class="slide-title">STATELESS</h1>
            <div class="slide-line"></div>
            <p class="slide-sub">Define tu mundo. Sin etiquetas.</p>
            <a href="{{ route('essentials') }}" class="slide-cta">Ver Essentials</a>
        </div>
    </div>

    <!-- Slide 2 -->
    <div class="hero-slide">
        <div class="slide-bg" style="background: linear-gradient(135deg, #111 0%, #1c1c1c 50%, #0a0a0a 100%);"></div>
        <div class="noise-overlay"></div>
        <div class="slide-content">
            <p class="slide-tag">Colección</p>
            <h1 class="slide-title">WAVES</h1>
            <div class="slide-line"></div>
            <p class="slide-sub">Fluye. Sin resistencia.</p>
            <a href="{{ route('waves') }}" class="slide-cta">Explorar colección</a>
        </div>
    </div>

    <!-- Slide 3 -->
    <div class="hero-slide">
        <div class="slide-bg" style="background: linear-gradient(135deg, #0a0a0a 0%, #111 50%, #1a1a1a 100%);"></div>
        <div class="noise-overlay"></div>
        <div class="slide-content">
            <p class="slide-tag">Colección</p>
            <h1 class="slide-title">OCTANE</h1>
            <div class="slide-line"></div>
            <p class="slide-sub">Velocidad, calle y actitud.</p>
            <a href="{{ route('octane') }}" class="slide-cta">Explorar colección</a>
        </div>
    </div>

    <!-- Controles -->
    <button class="hero-ctrl" onclick="cambiarSlide(-1)" style="left:24px;">‹</button>
    <button class="hero-ctrl" onclick="cambiarSlide(1)" style="right:24px;">›</button>

    <!-- Dots -->
    <div class="hero-dots">
        <button class="hero-dot active" onclick="irASlide(0)"></button>
        <button class="hero-dot" onclick="irASlide(1)"></button>
        <button class="hero-dot" onclick="irASlide(2)"></button>
    </div>

    <!-- Contador -->
    <div class="slide-counter">
        <span id="slide-num">01</span> / 03
    </div>
</section>

<!-- ESSENTIALS -->
<section class="essentials-section" id="essentials">
    <div class="section-header">
        <div class="section-header-left">
            <p>Destacados</p>
            <h2>ESSENTIALS</h2>
        </div>
        <div class="section-header-right">
            <a href="{{ route('essentials') }}">Ver toda la colección →</a>
        </div>
    </div>

    <div class="essentials-track-wrap">
        <div class="essentials-track" id="essentials-track">
            @forelse($essentials as $i => $producto)
            <div class="essentials-item">
                <a href="{{ route('producto.show', $producto) }}" style="text-decoration:none; color:#000;">
                    <div class="essentials-img-wrap">
                        <span class="item-num">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                        @if($producto->imagen)
                            <img src="{{ asset('images/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                        @else
                            <div style="background:#111; width:100%; height:480px;"></div>
                        @endif
                    </div>
                </a>

                <div class="essentials-item-body">
                    <a href="{{ route('producto.show', $producto) }}" style="text-decoration:none;">
                        <p class="essentials-item-name">{{ $producto->nombre }}</p>
                    </a>
                    <p class="essentials-item-price">${{ number_format($producto->precio, 0) }} COP</p>

                    @if(Auth::check())
                        <button onclick="agregarAlCarrito(this.dataset.id, this)"
                                data-id="{{ $producto->id }}"
                                class="btn-stateless"
                                style="width:100%; text-align:center;">
                            Añadir al carrito
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="btn-stateless"
                           style="width:100%; text-align:center; display:block;">
                            Añadir al carrito
                        </a>
                    @endif
                </div>
            </div>
            @empty
            <p style="opacity:0.4; font-size:13px; color:#fff;">No hay productos disponibles.</p>
            @endforelse
        </div>

        <button class="essentials-ctrl" onclick="moverEssentials(-1)" style="left:0;">‹</button>
        <button class="essentials-ctrl" onclick="moverEssentials(1)" style="right:0;">›</button>
    </div>
</section>

<script>
/* ── HERO CARRUSEL ── */
let slideActual = 0;
const slides = document.querySelectorAll('.hero-slide');
const dots = document.querySelectorAll('.hero-dot');
const totalSlides = slides.length;

function irASlide(index) {
    slides[slideActual].classList.remove('active');
    dots[slideActual].classList.remove('active');
    slideActual = (index + totalSlides) % totalSlides;
    slides[slideActual].classList.add('active');
    dots[slideActual].classList.add('active');
    document.getElementById('slide-num').textContent =
        String(slideActual + 1).padStart(2, '0');
}

function cambiarSlide(dir) { irASlide(slideActual + dir); }

setInterval(() => cambiarSlide(1), 5500);

/* ── ESSENTIALS CARRUSEL ── */
let essentialsIndex = 0;
const track = document.getElementById('essentials-track');
const totalItems = {{ $essentials->count() }};
const visibles = 3;

function moverEssentials(dir) {
    const max = totalItems - visibles;
    essentialsIndex = Math.max(0, Math.min(essentialsIndex + dir, max));
    const itemWidth = track.offsetWidth / visibles + 20 / visibles;
    track.style.transform = `translateX(-${essentialsIndex * (track.offsetWidth / visibles + 20 / visibles)}px)`;
}

setInterval(() => {
    const max = totalItems - visibles;
    if (essentialsIndex >= max) essentialsIndex = -1;
    moverEssentials(1);
}, 4000);

/* ── CARRITO ── */
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
</script>

@endsection