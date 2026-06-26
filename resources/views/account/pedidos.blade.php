@extends('layouts.app')

@section('content')
<section style="padding:60px 40px; max-width:900px; margin:0 auto;">

    <h1 style="font-family:'Bebas Neue', sans-serif; font-size:36px; letter-spacing:3px; margin-bottom:8px;">MIS PEDIDOS</h1>
    <p style="opacity:0.5; margin-bottom:32px;">Historial de compras</p>

    @forelse($ventas as $venta)
    <div style="border:1px solid #eee; padding:24px; margin-bottom:20px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div>
                <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4;">Pedido</p>
                <p style="font-family:'Bebas Neue', sans-serif; font-size:20px;">#{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div>
                <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4;">Fecha</p>
                <p>{{ $venta->created_at->format('d/m/Y') }}</p>
            </div>
            <div>
                <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4;">Total</p>
                <p style="font-family:'Bebas Neue', sans-serif; font-size:20px;">${{ number_format($venta->total, 2) }}</p>
            </div>
            <div>
                <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; opacity:0.4;">Estado</p>
                <p>{{ ucfirst($venta->estado ?? 'pendiente') }}</p>
            </div>
        </div>

        <table style="width:100%; font-size:13px;">
            @foreach($venta->items as $item)
            <tr style="border-top:1px solid #f0f0f0;">
                <td style="padding:8px 0;">{{ $item->producto->nombre ?? 'Producto eliminado' }}</td>
                <td style="padding:8px 0; text-align:center;">x{{ $item->cantidad }}</td>
                <td style="padding:8px 0; text-align:right;">${{ number_format($item->precio_unitario, 2) }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    @empty
    <p style="opacity:0.4; text-align:center; padding:40px;">Aún no tienes pedidos.</p>
    @endforelse

</section>
@endsection