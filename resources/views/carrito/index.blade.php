@extends('layouts.app')

@section('content')
<section style="padding: 60px; max-width: 1000px; margin: 0 auto;">

    <h1 style="font-family:'Bebas Neue', sans-serif; font-size:48px; letter-spacing:4px; margin-bottom:8px;">MI CARRITO</h1>
    <p style="font-size:13px; opacity:0.5; letter-spacing:1px; margin-bottom:40px;">{{ $carrito->items->count() }} producto(s)</p>

    @if(session('success'))
        <div style="background:#000; color:#fff; padding:12px 20px; font-size:12px; letter-spacing:1px; margin-bottom:24px;">
            {{ session('success') }}
        </div>
    @endif

    @if($carrito->items->count() > 0)

        <!-- ITEMS -->
        <div style="border-top: 2px solid #000;">
            @foreach($carrito->items as $item)
            <div style="display:flex; align-items:center; gap:24px; padding:24px 0; border-bottom:1px solid #eee;">

                <!-- Imagen placeholder -->
               @if($item->producto->imagen)
    <img src="{{ asset('images/' . $item->producto->imagen) }}" style="width:100px; height:120px; object-fit:cover; flex-shrink:0;">
@else
    <div style="width:100px; height:120px; background:#f2f2f2; flex-shrink:0;"></div>
@endif

                <!-- Info -->
                <div style="flex:1;">
                    <p style="font-family:'Bebas Neue', sans-serif; font-size:20px; letter-spacing:2px;">{{ $item->producto->nombre }}</p>
                    <p style="font-size:13px; opacity:0.5; margin-top:4px;">{{ ucfirst($item->producto->estado) }}</p>
                    <p style="font-size:14px; font-weight:600; margin-top:8px;">${{ number_format($item->precio_unitario, 2) }}</p>
                </div>

                <!-- Cantidad -->
                <form action="{{ route('carrito.actualizar', $item) }}" method="POST" style="display:flex; align-items:center; gap:8px;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" name="cantidad" value="{{ $item->cantidad - 1 }}" style="background:#f2f2f2; border:none; width:32px; height:32px; font-size:16px; cursor:pointer;" {{ $item->cantidad <= 1 ? 'disabled' : '' }}>−</button>
                    <span style="font-size:14px; font-weight:600; width:24px; text-align:center;">{{ $item->cantidad }}</span>
                    <button type="submit" name="cantidad" value="{{ $item->cantidad + 1 }}" style="background:#f2f2f2; border:none; width:32px; height:32px; font-size:16px; cursor:pointer;">+</button>
                </form>

                <!-- Subtotal -->
                <div style="text-align:right; min-width:100px;">
                    <p style="font-family:'Bebas Neue', sans-serif; font-size:20px;">${{ number_format($item->subtotal(), 2) }}</p>
                </div>

                <!-- Eliminar -->
                <form action="{{ route('carrito.eliminar', $item) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none; border:none; font-size:18px; cursor:pointer; opacity:0.3;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.3">✕</button>
                </form>

            </div>
            @endforeach
        </div>

        <!-- TOTAL -->
        <div style="display:flex; justify-content:space-between; align-items:center; padding:32px 0; border-top:2px solid #000; margin-top:8px;">
            <form action="{{ route('carrito.vaciar') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="background:none; border:none; font-size:12px; letter-spacing:2px; text-transform:uppercase; cursor:pointer; opacity:0.4;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.4" onclick="return confirm('¿Vaciar carrito?')">Vaciar carrito</button>
            </form>
            <div style="text-align:right;">
                <p style="font-size:12px; letter-spacing:2px; text-transform:uppercase; opacity:0.5; margin-bottom:8px;">Total</p>
                <p style="font-family:'Bebas Neue', sans-serif; font-size:40px; letter-spacing:2px;">${{ number_format($carrito->total(), 2) }}</p>
                <a href="{{ route('checkout.index') }}" class="btn-stateless" style="margin-top:16px;">Proceder al pago</a>
            </div>
        </div>

    @else
        <div style="text-align:center; padding:80px 0;">
            <p style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:4px; opacity:0.2;">TU CARRITO ESTÁ VACÍO</p>
            <a href="{{ url('/') }}" class="btn-stateless" style="margin-top:24px;">Ver productos</a>
        </div>
    @endif

</section>
@endsection