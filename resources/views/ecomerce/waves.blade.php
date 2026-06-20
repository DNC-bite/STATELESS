@extends('layouts.navbar_waves')


@section('content')


<section style="
    background:#fff;
    min-height:85vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:80px 40px;
    position:relative;
    overflow:hidden;
">
    <canvas id="waveCanvas" style="position:absolute; top:0; left:0; width:100%; height:100%;"></canvas>

    <div style="
        position:relative;
        z-index:2;
        width:100%;
        max-width:1100px;
        text-align:center;
        display:flex;
        flex-direction:column;
        justify-content:flex-end;
        align-items:center;
        gap:20px;
        margin-top:350px;
    ">
        <h1 style="position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0;">
            WAVES - Colección de ropa inspirada en el sonido y las frecuencias
        </h1>

        <p style="font-size:12px; letter-spacing:5px; text-transform:uppercase; color:#111; margin:0; font-weight:500;">
            Más allá del ruido
        </p>

        <a href="#catalogo" style="
            display:inline-block;
            padding:14px 38px;
            border:1px solid #111;
            color:#111;
            text-decoration:none;
            text-transform:uppercase;
            letter-spacing:3px;
            font-size:12px;
            font-weight:600;
            transition:.3s;
            background:rgba(255,255,255,.7);
            backdrop-filter:blur(10px);
        "
        onmouseover="this.style.background='#111';this.style.color='#fff';"
        onmouseout="this.style.background='rgba(255,255,255,.7)';this.style.color='#111';">
            Ver colección
        </a>
    </div>
</section>


<section id="catalogo" style="padding:80px 40px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:36px; flex-wrap:wrap; gap:16px;">
        <div>
            <p style="font-size:12px; letter-spacing:4px; text-transform:uppercase; opacity:0.5; margin-bottom:8px;">Catálogo</p>
            <img src="{{ asset('images/waves_nav/ropa_waves.png') }}" style="height: 50px; width: auto;" alt="Inicio">
        </div>
    </div>


    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:30px;">
        @forelse($waves as $producto)
        <div style="border:1px solid hsl(0, 0%, 0%); padding:16px;">
            <a href="{{ route('producto.show', $producto) }}" style="text-decoration:none; color:#000;">
                @if($producto->imagen)
                    <img src="{{ asset('images/' . $producto->imagen) }}" style="width:100%; aspect-ratio:3/4; object-fit:cover; margin-bottom:16px;">
                @else
                    <div style="background:#f2f2f2; aspect-ratio:3/4; margin-bottom:16px;"></div>
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

<script>
const canvas = document.getElementById('waveCanvas');
const ctx = canvas.getContext('2d');
let t = 0;

function resize() {
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;
}
window.addEventListener('resize', resize);
resize();

function drawFrame() {
    const W = canvas.width;
    const H = canvas.height;

    ctx.fillStyle = '#fff';
    ctx.fillRect(0, 0, W, H);

    const numCols = 64;
    const numRows = 22;
    const dotR = 5;
    const gapX = W / numCols;
    const gapY = H / numRows;

    for (let col = 0; col < numCols; col++) {
        const x = col * gapX + gapX / 2;
        const normX = (col / numCols) * 2 - 1;

        const wave1 = Math.sin(normX * Math.PI * 3 + t * 1.8) * 0.5;
        const wave2 = Math.sin(normX * Math.PI * 5 - t * 2.3) * 0.3;
        const wave3 = Math.sin(normX * Math.PI * 1.5 + t * 0.9) * 0.2;
        const amp = Math.abs(wave1 + wave2 + wave3);
        const litRows = Math.round(amp * (numRows / 2));

        for (let row = 0; row < numRows; row++) {
            const y = row * gapY + gapY / 2;
            const rowFromCenter = Math.abs(row - (numRows / 2 - 0.5));
            const lit = rowFromCenter <= litRows;

            if (lit) {
                const intensity = 1 - (rowFromCenter / (numRows / 2)) * 0.4;
                ctx.fillStyle = `rgba(0,0,0,${intensity})`;
            } else {
                ctx.fillStyle = 'rgba(0,0,0,0.07)';
            }

            ctx.beginPath();
            ctx.arc(x, y, dotR, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    // Knockout del texto
    ctx.save();
    ctx.globalCompositeOperation = 'destination-out';
    ctx.font = `bold ${W * 0.13}px Arial Black, Arial, sans-serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillStyle = 'rgba(255,255,255,1)';
    ctx.fillText('WAVES', W / 2, H / 2);
    ctx.restore();

    // Outline letras
    ctx.save();
    ctx.font = `bold ${W * 0.13}px Arial Black, Arial, sans-serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.strokeStyle = 'rgba(0,0,0,0.85)';
    ctx.lineWidth = 2;
    ctx.strokeText('WAVES', W / 2, H / 2);
    ctx.restore();

    t += 0.04;
    requestAnimationFrame(drawFrame);
}

drawFrame();
</script>
@endsection

