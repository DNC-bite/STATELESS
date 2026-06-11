@extends('layouts.app')


@section('content')


<section style="background:#000; color:#fff; min-height:85vh; display:flex; align-items:center; justify-content:center; padding:80px 40px;">
    <div style="width:100%; max-width:1100px; text-align:center;">
        <p style="font-size:12px; letter-spacing:6px; text-transform:uppercase; opacity:0.5; margin-bottom:18px;">Nueva Colección 2025</p>
        <h1 style="font-family:'Bebas Neue', sans-serif; font-size:96px; letter-spacing:8px; line-height:0.95; margin-bottom:20px;">THE CHROMA LIFE</h1>
        <p style="font-size:14px; letter-spacing:3px; text-transform:uppercase; opacity:0.7; margin-bottom:32px;">Color, vibra y expresión sin límites.</p>
        <a href="#catalogo" class="btn-stateless">Ver ropa</a>
    </div>
</section>


<section id="catalogo" style="padding:80px 40px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:36px; flex-wrap:wrap; gap:16px;">
        <div>
            <p style="font-size:12px; letter-spacing:4px; text-transform:uppercase; opacity:0.5; margin-bottom:8px;">Catálogo</p>
            <h2 style="font-family:'Bebas Neue', sans-serif; font-size:44px; letter-spacing:4px;">THE CHROMA LIFE</h2>
        </div>
    </div>


    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:30px;">
        @forelse($chromaLife as $producto)
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


@endsection
