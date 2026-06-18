@extends('layouts.navbar_octane')

@section('content')

<style>

:root{
    --drift-blue:#af0eaf;
    --drift-purple:#8b5cf6;
    --drift-dark:#050505;
    --drift-card:#101010;
    --drift-border:#232323;
}


body{
    background:#000;
    color:#fff;
}

/* HERO */

.hero-octane{
    min-height:100vh;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    overflow:hidden;
}

.hero-content::before{
    content:'';
    position:absolute;
    width:450px;
    height:450px;
    left:50%;
    top:50%;
    transform:translate(-50%,-50%);
    background:radial-gradient(
        circle,
        rgba(175,14,175,.25),
        transparent
    );
    filter:blur(80px);
    z-index:-1;
}

.hero-content{
    position:relative;
    z-index:2;
    transition:transform .15s linear;
}

.hero-content::before{
    content:'';
    position:absolute;
    width:450px;
    height:450px;
    left:50%;
    top:50%;
    transform:translate(-50%,-50%);
    background:radial-gradient(
        circle,
        rgba(134,10,134,.25),
        transparent
    );
    filter:blur(80px);
    z-index:-1;
}

.hero-content h1{
    font-family:'Bebas Neue',sans-serif;
    font-size:clamp(5rem,12vw,10rem);
    letter-spacing:10px;
    line-height:.9;
    margin-bottom:20px;
}

.hero-content .tag{
    font-size:12px;
    letter-spacing:6px;
    text-transform:uppercase;
    color:var(--drift-blue);
    margin-bottom:15px;
}

.hero-content p{
    letter-spacing:4px;
    text-transform:uppercase;
    opacity:.8;
}

.btn-octane{
    border:1px solid var(--drift-blue);
    color:#fff;
    padding:14px 35px;
    text-decoration:none;
    display:inline-block;
    transition:.3s;
    letter-spacing:2px;
    text-transform:uppercase;
}

.btn-octane:hover{
    background:var(--drift-blue);
    color:#000;
}

/* STORY */

.story-section{
    padding:120px 40px;
    text-align:center;
    background:linear-gradient(
        180deg,
        #050505,
        #0d0d0d
    );
}

.story-section span{
    color:var(--drift-blue);
    letter-spacing:4px;
    text-transform:uppercase;
}

.story-section h2{
    font-family:'Bebas Neue',sans-serif;
    font-size:5rem;
    letter-spacing:6px;
    margin:15px 0;
}

.story-section p{
    max-width:700px;
    margin:auto;
    opacity:.7;
    line-height:1.8;
}

/* TELEMETRY */

.telemetry{
    background:#050505;
    padding:80px 40px;
}

.telemetry-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

.telemetry-card{
    background:var(--drift-card);
    border:1px solid var(--drift-border);
    padding:25px;
    text-align:center;
}

.telemetry-card span{
    opacity:.5;
    letter-spacing:2px;
}

.telemetry-card h3{
    color:var(--drift-blue);
    margin-top:10px;
    font-size:2.5rem;
}

/* CATALOGO */

.catalogo{
    padding:100px 40px;
}

.catalog-header{
    margin-bottom:50px;
    text-align:center;
}

.catalog-header p{
    opacity:.5;
    letter-spacing:4px;
}

.catalog-header h2{
    font-family:'Bebas Neue',sans-serif;
    font-size:4rem;
    letter-spacing:5px;
}

.product-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:30px;
}

.product-card{
    background:var(--drift-card);
    border:1px solid var(--drift-border);
    transition:.3s;
}

.product-card:hover{
    transform:translateY(-8px);
    border-color:var(--drift-blue);
    box-shadow:0 0 25px rgba(0,229,255,.15);
}

.product-card img{
    width:100%;
    aspect-ratio:3/4;
    object-fit:cover;
}

.product-info{
    padding:20px;
}

.product-info h3{
    font-size:16px;
    letter-spacing:2px;
    text-transform:uppercase;
}

.product-spec{
    opacity:.6;
    font-size:13px;
    margin-top:8px;
}

.btn-cart{
    width:100%;
    border:none;
    background:transparent;
    border-top:1px solid var(--drift-border);
    color:white;
    padding:15px;
    transition:.3s;
    cursor:pointer;
    text-transform:uppercase;
    letter-spacing:2px;
}

.btn-cart:hover{
    background:var(--drift-blue);
    color:black;
}

.btn-cart:disabled{
    opacity:.5;
}

/* MOBILE */

@media(max-width:900px){

    .product-grid{
        grid-template-columns:1fr;
    }

    .telemetry-grid{
        grid-template-columns:1fr 1fr;
    }

    .story-section h2{
        font-size:3rem;
    }

}

.product-card:hover{
    transform:translateY(-8px);
    border-color:var(--drift-blue);
    box-shadow:0 0 25px rgba(175,14,175,.25);
}

</style>

<!-- HERO -->

<section class="hero-octane">

    <div class="hero-content">

        <div class="tag">
            OCTANE // DRIFT DIVISION
        </div>

        <h1>
            MIDNIGHT<br>DRIFT
        </h1>

        <p>
            CONTROL THROUGH CHAOS
        </p>

        <br>

        <a href="#catalogo" class="btn-octane">
            ENTER THE GARAGE
        </a>

    </div>

</section>

<!-- STORY -->

<section class="story-section">

    <span>DRIFT CULTURE</span>

    <h2>
        BUILT FOR
        LATE NIGHTS
    </h2>

    <p>
        Inspired by mountain passes, neon lights,
        tire smoke and empty roads.
        Designed for those who know that sometimes
        the fastest way forward is sideways.
    </p>

</section>

<!-- TELEMETRY -->

<section class="telemetry">

    <div class="telemetry-grid">

        <div class="telemetry-card">
            <span>DRIFT ANGLE</span>
            <h3 id="angle">48°</h3>
        </div>

        <div class="telemetry-card">
            <span>GRIP LEVEL</span>
            <h3 id="grip">62%</h3>
        </div>

        <div class="telemetry-card">
            <span>TIRE SMOKE</span>
            <h3 id="smoke">95%</h3>
        </div>

        <div class="telemetry-card">
            <span>TURBO BOOST</span>
            <h3 id="boost">1.6</h3>
        </div>

    </div>

</section>

<!-- CATALOGO -->

<section id="catalogo" class="catalogo">

    <div class="catalog-header">

        <p>MIDNIGHT RUN COLLECTION</p>

        <h2>DRIFT GARAGE</h2>

    </div>

    <div class="product-grid">

        @forelse($octane as $producto)

        <div class="product-card">

            <a href="{{ route('producto.show',$producto) }}"
               style="text-decoration:none;color:white;">

                @if($producto->imagen)

                    <img
                        src="{{ asset('images/'.$producto->imagen) }}"
                        alt="{{ $producto->nombre }}">

                @else

                    <div style="aspect-ratio:3/4;background:#1d1d1d;"></div>

                @endif

                <div class="product-info">

                    <h3>{{ $producto->nombre }}</h3>

                    <div class="product-spec">
                        SERIES // MIDNIGHT RUN
                    </div>

                    <div class="product-spec">
                        STATUS // READY
                    </div>

                    <div class="product-spec">
                        PRICE // ${{ number_format($producto->precio,2) }}
                    </div>

                </div>

            </a>

            @if(Auth::check())

                <button
                    onclick="agregarAlCarrito('{{ $producto->id }}', this)"
                    class="btn-cart">

                    JOIN THE GARAGE

                </button>

            @else

                <a href="{{ route('login') }}"
                   class="btn-cart"
                   style="display:block;text-align:center;text-decoration:none;">

                    JOIN THE GARAGE

                </a>

            @endif

        </div>

        @empty

            <p>No hay productos disponibles.</p>

        @endforelse

    </div>

</section>

<script>

/* Telemetría Drift */

setInterval(()=>{

    document.getElementById('angle').innerText =
    Math.floor(Math.random()*25+35) + '°';

    document.getElementById('grip').innerText =
    Math.floor(Math.random()*40+50) + '%';

    document.getElementById('smoke').innerText =
    Math.floor(Math.random()*20+80) + '%';

    document.getElementById('boost').innerText =
    (Math.random()*0.8+1.2).toFixed(1);

},1000);

/* Efecto Drift */

document.addEventListener('mousemove',(e)=>{

    const x =
    (e.clientX/window.innerWidth - 0.5) * 30;

    const hero =
    document.querySelector('.hero-content');

    if(hero){
        hero.style.transform =
        `translateX(${x}px)`;
    }

});

/* Carrito */

function agregarAlCarrito(productoId, btn) {
    const textoOriginal = btn.innerText;
    btn.disabled = true;
    btn.innerText = 'JOINING...';

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
            btn.innerText = 'JOINED ✓';
            let contador = document.getElementById('carrito-contador');
            if (contador) {
                contador.textContent = data.cantidad;
                contador.style.display = 'flex';
            }
        } else {
            btn.innerText = data.mensaje || 'ERROR';
        }
        setTimeout(() => {
            btn.innerText = textoOriginal;
            btn.disabled = false;
        }, 1500);
    })
    .catch(() => {
        btn.innerText = 'ERROR';
        setTimeout(() => {
            btn.innerText = textoOriginal;
            btn.disabled = false;
        }, 1500);
    });
}

</script>

@endsection
