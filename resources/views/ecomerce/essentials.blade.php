@extends('layouts.navbar_essentials')

@section('content')

<style>
    @keyframes lineSpeed {
    0%   { transform: translateX(-120px); opacity: 0; }
    10%  { opacity: 1; }
    90%  { opacity: 1; }
    100% { transform: translateX(100vw); opacity: 0; }
}
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(40px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes revealText {
        from { clip-path: inset(0 100% 0 0); }
        to   { clip-path: inset(0 0% 0 0); }
    }
    
    .speed-line {
        position: absolute;
        height: 1px;
        width: 120px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
        animation: lineSpeed linear infinite;
    }
    .producto-card {
        border: 1px solid #000;
        padding: 16px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: fadeUp 0.6s ease both;
    }
    .producto-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.15);
    }
    .rpm-bar {
        display: flex;
        gap: 3px;
        margin-bottom: 40px;
        justify-content: center;
    }
    .rpm-bar span {
        display: block;
        width: 6px;
        background: #fff;
        animation: rpmPulse 1.2s ease-in-out infinite;
    }
    .rpm-bar span:nth-child(1)  { height: 12px; animation-delay: 0s; }
    .rpm-bar span:nth-child(2)  { height: 24px; animation-delay: 0.1s; }
    .rpm-bar span:nth-child(3)  { height: 40px; animation-delay: 0.2s; }
    .rpm-bar span:nth-child(4)  { height: 56px; animation-delay: 0.3s; }
    .rpm-bar span:nth-child(5)  { height: 72px; animation-delay: 0.4s; }
    .rpm-bar span:nth-child(6)  { height: 56px; animation-delay: 0.5s; }
    .rpm-bar span:nth-child(7)  { height: 40px; animation-delay: 0.6s; }
    .rpm-bar span:nth-child(8)  { height: 24px; animation-delay: 0.7s; }
    .rpm-bar span:nth-child(9)  { height: 12px; animation-delay: 0.8s; }
    @keyframes rpmPulse {
        0%, 100% { opacity: 0.3; }
        50%       { opacity: 1; }
    }
    .hero-tag {
        display: inline-block;
        border: 1px solid rgba(255,255,255,0.3);
        padding: 6px 16px;
        font-size: 11px;
        letter-spacing: 5px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.5);
        margin-bottom: 24px;
        animation: fadeUp 0.6s ease 0.2s both;
    }
    .hero-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(64px, 12vw, 130px);
        letter-spacing: 10px;
        line-height: 0.9;
        margin-bottom: 8px;
        animation: revealText 1s ease 0.4s both;
    }
    .hero-sub {
        font-size: 11px;
        letter-spacing: 6px;
        text-transform: uppercase;
        opacity: 0.4;
        margin-bottom: 40px;
        animation: fadeUp 0.6s ease 0.8s both;
    }
    .hero-cta {
        display: inline-block;
        padding: 14px 40px;
        background: #fff;
        color: #000;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 4px;
        text-transform: uppercase;
        transition: all 0.3s;
        animation: fadeUp 0.6s ease 1s both;
    }
    .hero-cta:hover {
        background: transparent;
        color: #fff;
        outline: 1px solid #fff;
    }
    .section-label {
        font-size: 11px;
        letter-spacing: 5px;
        text-transform: uppercase;
        opacity: 0.4;
        margin-bottom: 8px;
    }
    .section-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 48px;
        letter-spacing: 4px;
        margin-bottom: 0;
    }
    .divider-speed {
        width: 100%;
        height: 1px;
        background: linear-gradient(90deg, transparent, #000, #000, transparent);
        margin: 40px 0;
        position: relative;
        overflow: hidden;
    }
    .divider-speed::after {
        content: '';
        position: absolute;
        top: 0;
        left: -20%;
        width: 20%;
        height: 100%;
        background: linear-gradient(90deg, transparent, #fff, transparent);
        animation: lineSpeed 2s ease-in-out infinite;
    }
</style>

<!-- HERO -->
<section style="
    position: relative;
    background: #000;
    color: #fff;
    min-height: 88vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 80px 40px;
    overflow: hidden;
">
    <!-- Líneas de velocidad -->
    <div class="speed-line" style="top:20%; left:0; animation-duration:2.1s; animation-delay:0s; width:200px;"></div>
    <div class="speed-line" style="top:35%; left:0; animation-duration:1.7s; animation-delay:0.4s; width:140px;"></div>
    <div class="speed-line" style="top:50%; left:0; animation-duration:2.4s; animation-delay:0.8s; width:300px;"></div>
    <div class="speed-line" style="top:65%; left:0; animation-duration:1.9s; animation-delay:0.2s; width:180px;"></div>
    <div class="speed-line" style="top:80%; left:0; animation-duration:2.2s; animation-delay:1.1s; width:120px;"></div>
    <div class="speed-line" style="top:10%; left:0; animation-duration:1.5s; animation-delay:1.5s; width:250px;"></div>
    <div class="speed-line" style="top:90%; left:0; animation-duration:2.8s; animation-delay:0.6s; width:160px;"></div>

    <!-- Línea vertical izquierda -->
    <div style="position:absolute; left:40px; top:10%; bottom:10%; width:1px; background:linear-gradient(180deg, transparent, rgba(255,255,255,0.15), transparent);"></div>
    <!-- Línea vertical derecha -->
    <div style="position:absolute; right:40px; top:10%; bottom:10%; width:1px; background:linear-gradient(180deg, transparent, rgba(255,255,255,0.15), transparent);"></div>

    <div style="position:relative; z-index:2; text-align:center; max-width:900px;">
        <!-- RPM bars -->
        <div class="rpm-bar">
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span>
        </div>

        <div class="hero-tag">Colección 2026 — Essentials</div>

        <h1 class="hero-title">ESSENTIALS</h1>

        <p style="
            font-family:'Bebas Neue', sans-serif;
            font-size: clamp(20px, 4vw, 42px);
            letter-spacing: 8px;
            opacity: 0.2;
            margin-bottom: 16px;
            animation: fadeUp 0.6s ease 0.6s both;
        ">DRIFT · STREET · STYLE</p>

        <p class="hero-sub">Ropa limpia, precisa y sin complicaciones.</p>

        <a href="#catalogo" class="hero-cta">Ver colección</a>
    </div>

    <!-- Número decorativo -->
    <div style="
        position: absolute;
        right: 60px;
        bottom: 40px;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 120px;
        color: rgba(255,255,255,0.04);
        line-height: 1;
        letter-spacing: -4px;
        user-select: none;
    ">01</div>
</section>

<!-- DIVIDER -->
<div style="background:#000; padding:16px 40px; display:flex; align-items:center; gap:24px;">
    <span style="font-size:11px; letter-spacing:4px; color:#fff; opacity:0.4; text-transform:uppercase; white-space:nowrap;">Essentials Drop 01</span>
    <div style="flex:1; height:1px; background:rgba(255,255,255,0.1);"></div>
    <span style="font-size:11px; letter-spacing:4px; color:#fff; opacity:0.4; text-transform:uppercase; white-space:nowrap;">{{ $essentials->count() }} piezas</span>
</div>

<!-- CATÁLOGO -->
<section id="catalogo" style="padding:80px 40px; background:#fff;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:48px; flex-wrap:wrap; gap:16px;">
        <div>
            <p class="section-label">Catálogo</p>
            <h2 class="section-title">ROPA ESSENTIALS</h2>
        </div>
        <div style="display:flex; gap:8px; align-items:center;">
            <div style="width:32px; height:1px; background:#000;"></div>
            <span style="font-size:11px; letter-spacing:3px; text-transform:uppercase; opacity:0.4;">Stock disponible</span>
        </div>
    </div>

    <div class="divider-speed"></div>

    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:24px;">
        @forelse($essentials as $i => $producto)
        <div class="producto-card" style="animation-delay:{{ $i * 0.1 }}s;">
            <a href="{{ route('producto.show', $producto) }}" style="text-decoration:none; color:#000; display:block;">
                <!-- Número de item -->
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                    <span style="font-family:'Bebas Neue',sans-serif; font-size:13px; letter-spacing:2px; opacity:0.2;">
                        {{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    @if($producto->stock_actual > 0)
                        <span style="font-size:10px; letter-spacing:2px; text-transform:uppercase; color:#000; opacity:0.4;">En stock</span>
                    @else
                        <span style="font-size:10px; letter-spacing:2px; text-transform:uppercase; color:#999;">Agotado</span>
                    @endif
                </div>

                @if($producto->imagen)
                    <div style="overflow:hidden; margin-bottom:16px;">
                        <img src="{{ asset('images/' . $producto->imagen) }}"
                             style="width:100%; aspect-ratio:3/4; object-fit:cover; transition:transform 0.5s ease; display:block;"
                             onmouseover="this.style.transform='scale(1.04)'"
                             onmouseout="this.style.transform='scale(1)'">
                    </div>
                @else
                    <div style="background:#f5f5f5; aspect-ratio:3/4; margin-bottom:16px;"></div>
                @endif

                <p style="font-size:12px; font-weight:700; letter-spacing:2px; text-transform:uppercase; margin-bottom:4px;">{{ $producto->nombre }}</p>
                <p style="font-size:13px; opacity:0.5; margin-bottom:16px; font-family:'Bebas Neue',sans-serif; letter-spacing:1px;">
                    ${{ number_format($producto->precio, 0) }}
                </p>
            </a>

            @if(Auth::check())
                <button onclick="agregarAlCarrito(this.dataset.id, this)"
                        data-id="{{ $producto->id }}"
                        class="btn-stateless"
                        style="width:100%; text-align:center;">
                    Añadir al carrito
                </button>
            @else
                <a href="{{ route('login') }}" class="btn-stateless" style="width:100%; text-align:center; display:block;">
                    Añadir al carrito
                </a>
            @endif
        </div>
        @empty
        <div style="grid-column:1/-1; text-align:center; padding:80px; opacity:0.3;">
            <p style="font-family:'Bebas Neue',sans-serif; font-size:32px; letter-spacing:4px;">Sin productos disponibles</p>
        </div>
        @endforelse
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
        btn.textContent = '✓ Agregado';
        let contador = document.getElementById('carrito-contador');
        if (contador) {
            contador.textContent = data.cantidad;
            contador.style.display = 'flex';
        }
        setTimeout(() => {
            btn.disabled = false;
            btn.textContent = 'Añadir al carrito';
        }, 2000);
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = 'Añadir al carrito';
    });
}
</script>

@endsection