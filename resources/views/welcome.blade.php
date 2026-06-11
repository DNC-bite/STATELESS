@extends('layouts.app')

@section('content')

<!-- HERO -->
<section style="background:#000; color:#fff; min-height:90vh; display:flex; align-items:center; justify-content:center; text-align:center; padding: 60px 40px;">
    <div>
        <p style="font-size:12px; letter-spacing:6px; text-transform:uppercase; opacity:0.5; margin-bottom:20px;">Nueva Colección 2025</p>
        <h1 style="font-family:'Bebas Neue', sans-serif; font-size:120px; letter-spacing:10px; line-height:1; margin-bottom:20px;">STATELESS</h1>
        <p style="font-size:14px; letter-spacing:3px; text-transform:uppercase; opacity:0.7; margin-bottom:40px;">Define tu mundo. Sin etiquetas.</p>
        <div style="display:flex; gap:20px; justify-content:center;">
            <a href="{{ route('essentials') }}" class="btn-stateless">Ver Essentials</a>
            <a href="{{ route('chroma-life') }}" class="btn-stateless-outline" style="color:#000; border-color:#000;">The Chroma Life</a>
        </div>
    </div>
</section>

<!-- SECCIÓN de Productos -->
<section style="padding: 80px 60px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:40px;">
        <h2 style="font-family:'Bebas Neue', sans-serif; font-size:48px; letter-spacing:4px;">Productos</h2>
        <a href="#" style="font-size:12px; letter-spacing:2px; text-transform:uppercase; color:#000; text-decoration:none; border-bottom:1px solid #000;">Ver todo</a>
    </div>
    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:30px;">
    @forelse($essentials as $producto)
    <div>
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