@extends('layouts.app')

@section('content')

<!-- DETALLE PRODUCTO -->
<section style="padding: 80px 60px; max-width:1200px; margin:0 auto;">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:start;">

        <!-- IMAGEN -->
        @if($producto->imagen)
    <img src="{{ asset('images/' . $producto->imagen) }}" style="width:100%; aspect-ratio:3/4; object-fit:cover;">
@else
    <div style="background:#f2f2f2; aspect-ratio:3/4;"></div>
@endif

        <!-- INFO -->
        <div>
            <p style="font-size:11px; letter-spacing:3px; text-transform:uppercase; opacity:0.4; margin-bottom:12px;">{{ $producto->categoria->nombre ?? '' }}</p>
            <h1 style="font-family:'Bebas Neue', sans-serif; font-size:56px; letter-spacing:4px; margin-bottom:16px;">{{ $producto->nombre }}</h1>
            <p style="font-family:'Bebas Neue', sans-serif; font-size:36px; letter-spacing:2px; margin-bottom:24px;">${{ number_format($producto->precio, 2) }}</p>
            <p style="font-size:14px; line-height:1.8; opacity:0.7; margin-bottom:32px;">{{ $producto->descripcion }}</p>

            @if(Auth::check())
                <form action="{{ route('carrito.agregar', $producto) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-stateless" style="width:100%; padding:16px; font-size:13px;">Añadir al carrito</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-stateless" style="width:100%; padding:16px; font-size:13px; text-align:center; display:block;">Iniciar sesión para comprar</a>
            @endif

            <!-- Info extra -->
            <div style="margin-top:32px; padding-top:24px; border-top:1px solid #eee;">
                <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4; margin-bottom:8px;">Stock disponible</p>
                <p style="font-size:14px; font-weight:600;">{{ $producto->stock_actual }} unidades</p>
            </div>
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
                <div style="background:#f2f2f2; aspect-ratio:3/4; margin-bottom:16px;"></div>
                <p style="font-size:13px; font-weight:600; letter-spacing:1px; text-transform:uppercase;">{{ $rel->nombre }}</p>
                <p style="font-size:13px; opacity:0.5;">${{ number_format($rel->precio, 2) }}</p>
            </a>
        </div>
        @endforeach
    </div>
</section>
@endif

@endsection