@extends('layouts.navbar_octane')

@section('content')

<style>
:root {
    --drift-blue: #af0eaf;
    --drift-purple: #8b5cf6;
    --drift-dark: #050505;
    --drift-card: #101010;
    --drift-border: #232323;
}

body { background: #000; color: #fff; }

/* HERO */
.hero-octane {
    min-height: 100vh;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
    background: #000;
}

.hero-content {
    position: relative;
    z-index: 2;
    transition: transform .15s linear;
}

.hero-content h1 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(5rem, 12vw, 10rem);
    letter-spacing: 10px;
    line-height: .9;
    margin-bottom: 20px;
}

.hero-content .tag {
    font-size: 12px;
    letter-spacing: 6px;
    text-transform: uppercase;
    color: var(--drift-blue);
    margin-bottom: 15px;
}

.btn-octane {
    border: 1px solid var(--drift-blue);
    color: #fff;
    padding: 14px 35px;
    text-decoration: none;
    display: inline-block;
    transition: .3s;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.btn-octane:hover {
    background: var(--drift-blue);
    color: #000;
}

/* RPM METER */
.rpm-section {
    background: #050505;
    padding: 60px 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 60px;
    flex-wrap: wrap;
    border-top: 1px solid #1a1a1a;
    border-bottom: 1px solid #1a1a1a;
}

.rpm-gauge {
    text-align: center;
}

.rpm-gauge-label {
    font-size: 10px;
    letter-spacing: 4px;
    text-transform: uppercase;
    opacity: .4;
    margin-bottom: 12px;
}

.rpm-bars {
    display: flex;
    gap: 4px;
    align-items: flex-end;
    height: 60px;
    justify-content: center;
}

.rpm-bar-item {
    width: 8px;
    border-radius: 2px 2px 0 0;
    transition: height .15s ease, background .15s ease;
}

.rpm-value {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 28px;
    letter-spacing: 2px;
    color: var(--drift-blue);
    margin-top: 8px;
}

/* STORY */
.story-section {
    padding: 120px 40px;
    text-align: center;
    background: linear-gradient(180deg, #050505, #0d0d0d);
}

.story-section span {
    color: var(--drift-blue);
    letter-spacing: 4px;
    text-transform: uppercase;
}

.story-section h2 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 5rem;
    letter-spacing: 6px;
    margin: 15px 0;
}

.story-section p {
    max-width: 700px;
    margin: auto;
    opacity: .7;
    line-height: 1.8;
}

/* CATALOGO */
.catalogo { padding: 100px 40px; }

.catalog-header {
    margin-bottom: 50px;
    text-align: center;
}

.catalog-header p { opacity: .5; letter-spacing: 4px; }

.catalog-header h2 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 4rem;
    letter-spacing: 5px;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

/* PRODUCT CARD con efecto escáner */
.product-card {
    background: var(--drift-card);
    border: 1px solid var(--drift-border);
    transition: .3s;
    position: relative;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px);
    border-color: var(--drift-blue);
    box-shadow: 0 0 25px rgba(175, 14, 175, .25);
}

.product-img-wrap {
    position: relative;
    overflow: hidden;
}

.product-img-wrap::after {
    content: '';
    position: absolute;
    top: -100%;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--drift-blue), transparent);
    box-shadow: 0 0 12px var(--drift-blue);
    transition: none;
    opacity: 0;
}

.product-card:hover .product-img-wrap::after {
    animation: scanner 1.2s ease forwards;
}

@keyframes scanner {
    0%   { top: 0%;   opacity: 1; }
    100% { top: 100%; opacity: 0.3; }
}

.product-card img {
    width: 100%;
    aspect-ratio: 3/4;
    object-fit: cover;
    transition: transform .5s ease;
}

.product-card:hover img {
    transform: scale(1.04);
}

/* Overlay escáner texto */
.scan-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(180deg, transparent 60%, rgba(175,14,175,.15));
    opacity: 0;
    transition: opacity .3s;
    pointer-events: none;
}

.product-card:hover .scan-overlay { opacity: 1; }

.product-info { padding: 20px; }

.product-info h3 {
    font-size: 16px;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.product-spec {
    opacity: .6;
    font-size: 13px;
    margin-top: 8px;
    font-family: monospace;
    letter-spacing: 1px;
}

/* Barra de estado */
.status-bar {
    display: flex;
    gap: 3px;
    margin-top: 12px;
    margin-bottom: 4px;
}

.status-pip {
    flex: 1;
    height: 3px;
    background: var(--drift-border);
    border-radius: 2px;
    transition: background .3s;
}

.status-pip.active { background: var(--drift-blue); }

.btn-cart {
    width: 100%;
    border: none;
    background: transparent;
    border-top: 1px solid var(--drift-border);
    color: white;
    padding: 15px;
    transition: .3s;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-family: monospace;
}

.btn-cart:hover {
    background: var(--drift-blue);
    color: #000;
}

.btn-cart:disabled { opacity: .5; }

@media(max-width: 900px) {
    .product-grid { grid-template-columns: 1fr; }
    .story-section h2 { font-size: 3rem; }
}
</style>

<!-- CANVAS HUMO -->
<canvas id="smokeCanvas" style="position:fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:0; opacity:0.18;"></canvas>

<!-- HERO -->
<section class="hero-octane">
    <div class="hero-content">
        <div class="tag">OCTANE // DRIFT DIVISION</div>
        <h1>MIDNIGHT<br>DRIFT</h1>
        <p style="letter-spacing:4px; text-transform:uppercase; opacity:.8;">CONTROL THROUGH CHAOS</p>
        <br>
        <a href="#catalogo" class="btn-octane">ENTER THE GARAGE</a>
    </div>
</section>

<!-- RPM METERS -->
<section class="rpm-section">
    <div class="rpm-gauge">
        <div class="rpm-gauge-label">Drift Angle</div>
        <div class="rpm-bars" id="bars-angle"></div>
        <div class="rpm-value" id="val-angle">48°</div>
    </div>
    <div class="rpm-gauge">
        <div class="rpm-gauge-label">Grip Level</div>
        <div class="rpm-bars" id="bars-grip"></div>
        <div class="rpm-value" id="val-grip">62%</div>
    </div>
    <div class="rpm-gauge">
        <div class="rpm-gauge-label">Tire Smoke</div>
        <div class="rpm-bars" id="bars-smoke"></div>
        <div class="rpm-value" id="val-smoke">95%</div>
    </div>
    <div class="rpm-gauge">
        <div class="rpm-gauge-label">Turbo Boost</div>
        <div class="rpm-bars" id="bars-boost"></div>
        <div class="rpm-value" id="val-boost">1.6</div>
    </div>
</section>

<!-- STORY -->
<section class="story-section">
    <span>DRIFT CULTURE</span>
    <h2>BUILT FOR<br>LATE NIGHTS</h2>
    <p>
        Inspired by mountain passes, neon lights,
        tire smoke and empty roads.
        Designed for those who know that sometimes
        the fastest way forward is sideways.
    </p>
</section>

<!-- CATALOGO -->
<section id="catalogo" class="catalogo">
    <div class="catalog-header">
        <p>MIDNIGHT RUN COLLECTION</p>
        <h2>DRIFT GARAGE</h2>
    </div>

    <div class="product-grid">
        @forelse($octane as $i => $producto)
        <div class="product-card">
            <a href="{{ route('producto.show', $producto) }}" style="text-decoration:none; color:white;">
                <div class="product-img-wrap">
                    @if($producto->imagen)
                        <img src="{{ asset('images/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                    @else
                        <div style="aspect-ratio:3/4; background:#1d1d1d;"></div>
                    @endif
                    <div class="scan-overlay"></div>
                </div>

                <div class="product-info">
                    <div style="font-size:10px; letter-spacing:3px; opacity:.3; margin-bottom:6px; font-family:monospace;">
                        UNIT-{{ str_pad($i+1, 3, '0', STR_PAD_LEFT) }} // OCTANE
                    </div>
                    <h3>{{ $producto->nombre }}</h3>
                    <div class="product-spec">SERIES &gt;&gt; MIDNIGHT RUN</div>
                    <div class="product-spec">PRICE &gt;&gt; ${{ number_format($producto->precio, 0) }}</div>

                    <!-- Barra de estado estilo carga -->
                    <div class="status-bar">
                        @for($p = 0; $p < 8; $p++)
                            <div class="status-pip {{ $p < 6 ? 'active' : '' }}"></div>
                        @endfor
                    </div>
                    <div style="font-size:10px; letter-spacing:2px; opacity:.4; font-family:monospace;">STATUS: READY</div>
                </div>
            </a>

            @if(Auth::check())
                <button onclick="agregarAlCarrito('{{ $producto->id }}', this)" class="btn-cart">
                    [ JOIN THE GARAGE ]
                </button>
            @else
                <a href="{{ route('login') }}" class="btn-cart" style="display:block; text-align:center; text-decoration:none;">
                    [ JOIN THE GARAGE ]
                </a>
            @endif
        </div>
        @empty
            <p style="opacity:.4;">No hay productos disponibles.</p>
        @endforelse
    </div>
</section>

<script>
/* ── HUMO CON CANVAS ── */
const canvas = document.getElementById('smokeCanvas');
const ctx = canvas.getContext('2d');

function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}
window.addEventListener('resize', resizeCanvas);
resizeCanvas();

const particles = [];

class SmokeParticle {
    constructor() { this.reset(); }
    reset() {
        this.x = Math.random() * canvas.width;
        this.y = canvas.height + 50;
        this.size = Math.random() * 80 + 40;
        this.speedY = -(Math.random() * 0.6 + 0.2);
        this.speedX = (Math.random() - 0.5) * 0.4;
        this.opacity = Math.random() * 0.4 + 0.1;
        this.fade = Math.random() * 0.003 + 0.001;
        this.grow = Math.random() * 0.3 + 0.1;
    }
    update() {
        this.y += this.speedY;
        this.x += this.speedX;
        this.size += this.grow;
        this.opacity -= this.fade;
        if (this.opacity <= 0) this.reset();
    }
    draw() {
        const grad = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.size);
        grad.addColorStop(0, `rgba(175,14,175,${this.opacity})`);
        grad.addColorStop(0.5, `rgba(80,0,80,${this.opacity * 0.5})`);
        grad.addColorStop(1, 'transparent');
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fillStyle = grad;
        ctx.fill();
    }
}

for (let i = 0; i < 25; i++) {
    const p = new SmokeParticle();
    p.y = Math.random() * canvas.height; // distribuir al inicio
    particles.push(p);
}

function animateSmoke() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach(p => { p.update(); p.draw(); });
    requestAnimationFrame(animateSmoke);
}
animateSmoke();

/* ── RPM BARS ── */
const gauges = [
    { barsId: 'bars-angle', valId: 'val-angle', min: 35, max: 60,  suffix: '°',  bars: 10 },
    { barsId: 'bars-grip',  valId: 'val-grip',  min: 50, max: 90,  suffix: '%',  bars: 10 },
    { barsId: 'bars-smoke', valId: 'val-smoke',  min: 80, max: 100, suffix: '%',  bars: 10 },
    { barsId: 'bars-boost', valId: 'val-boost',  min: 1.2, max: 2.0, suffix: '', bars: 10, decimal: true },
];

gauges.forEach(g => {
    const container = document.getElementById(g.barsId);
    for (let i = 0; i < g.bars; i++) {
        const bar = document.createElement('div');
        bar.className = 'rpm-bar-item';
        const h = 10 + (i / g.bars) * 50;
        bar.style.height = h + 'px';
        container.appendChild(bar);
    }
});

function updateGauges() {
    gauges.forEach(g => {
        const val = g.decimal
            ? (Math.random() * (g.max - g.min) + g.min)
            : Math.floor(Math.random() * (g.max - g.min) + g.min);

        const pct = (val - g.min) / (g.max - g.min);
        const activeBars = Math.round(pct * g.bars);

        const container = document.getElementById(g.barsId);
        container.querySelectorAll('.rpm-bar-item').forEach((bar, i) => {
            if (i < activeBars) {
                const intensity = i / g.bars;
                bar.style.background = i >= g.bars * 0.75
                    ? '#ff3366'
                    : i >= g.bars * 0.5
                        ? '#af0eaf'
                        : '#6b006b';
            } else {
                bar.style.background = '#1a1a1a';
            }
        });

        document.getElementById(g.valId).textContent =
            g.decimal ? val.toFixed(1) + g.suffix : val + g.suffix;
    });
}

updateGauges();
setInterval(updateGauges, 900);

/* ── EFECTO DRIFT MOUSE ── */
document.addEventListener('mousemove', (e) => {
    const x = (e.clientX / window.innerWidth - 0.5) * 30;
    const hero = document.querySelector('.hero-content');
    if (hero) hero.style.transform = `translateX(${x}px)`;
});

/* ── CARRITO ── */
function agregarAlCarrito(productoId, btn) {
    const textoOriginal = btn.innerText;
    btn.disabled = true;
    btn.innerText = '[ JOINING... ]';

    fetch(`/carrito/agregar/${productoId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            btn.innerText = '[ JOINED ✓ ]';
            let contador = document.getElementById('carrito-contador');
            if (contador) {
                contador.textContent = data.cantidad;
                contador.style.display = 'flex';
            }
        } else {
            btn.innerText = data.mensaje || '[ ERROR ]';
        }
        setTimeout(() => {
            btn.innerText = textoOriginal;
            btn.disabled = false;
        }, 1500);
    })
    .catch(() => {
        btn.innerText = '[ ERROR ]';
        setTimeout(() => {
            btn.innerText = textoOriginal;
            btn.disabled = false;
        }, 1500);
    });
}
</script>

@endsection