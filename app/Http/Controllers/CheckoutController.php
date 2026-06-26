<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Venta;
use App\Models\Envio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckoutController extends Controller
{
    public function index()
    {
        $carrito = Carrito::with('items.producto')
            ->where('user_id', Auth::id())
            ->first();

        if (!$carrito || $carrito->items->isEmpty()) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount'   => $carrito->total() * 100,
            'currency' => 'cop',
        ]);

        return view('checkout.index', [
            'carrito'      => $carrito,
            'clientSecret' => $paymentIntent->client_secret,
            'stripeKey'    => config('services.stripe.key'),
        ]);
    }
    public function pse($ventaId)
{
    $venta = Venta::with('envio')->findOrFail($ventaId);
    return view('checkout.pse', compact('venta'));
}
public function confirmarPse(Request $request, $ventaId)
{
    $request->validate([
        'banco_simulado' => 'required|in:banco_aprueba,banco_rechaza',
    ]);

    $venta = Venta::findOrFail($ventaId);

    if ($request->banco_simulado === 'banco_aprueba') {
        $venta->update(['estado' => 'pagada']);
        return redirect()->route('checkout.factura', $venta->id)
            ->with('success', 'Pago PSE simulado aprobado.');
    }

    return redirect()->route('checkout.index')
        ->with('error', 'El banco simulado rechazó el pago.');
}

    public function procesar(Request $request)
{
    $request->validate([
        'direccion'         => 'required|string|max:255',
        'ciudad'            => 'required|string|max:100',
        'payment_intent_id' => 'required|string',
    ]);

    $carrito = Carrito::with('items.producto')
        ->where('user_id', Auth::id())
        ->first();

    if (!$carrito || $carrito->items->isEmpty()) {
        return response()->json(['error' => 'Carrito vacío'], 400);
    }

    // Verificar stock
    foreach ($carrito->items as $item) {
        if ($item->producto->stock_actual < $item->cantidad) {
            return response()->json([
                'error' => 'Stock insuficiente para: ' . $item->producto->nombre
            ], 400);
        }
    }

    // Generar código Efecty si aplica
    $codigoPago = $request->metodo_pago === 'efecty' ? 'EFY-' . strtoupper(substr(uniqid(), -8)) : null;

    // Crear venta
    $venta = Venta::create([
        'tipo_venta'  => 'online',
        'metodo_pago' => $request->metodo_pago ?? 'tarjeta',
        'total'       => $carrito->total(),
        'user_id'     => Auth::id(),
        'codigo_pago' => $codigoPago,
    ]);

    // Crear envío
    Envio::create([
        'venta_id'  => $venta->id,
        'direccion' => $request->direccion,
        'ciudad'    => $request->ciudad,
        'estado'    => 'pendiente',
    ]);

    // Descontar stock
    foreach ($carrito->items as $item) {
        $item->producto->decrement('stock_actual', $item->cantidad);
    }

    // Vaciar carrito
    $carrito->items()->delete();

    return response()->json([
        'redirect' => $request->metodo_pago === 'pse'
            ? route('checkout.pse', $venta->id)
            : route('checkout.factura', $venta->id)
    ]);
}

    public function factura($ventaId)
    {
        $venta = Venta::with(['usuario', 'envio'])->findOrFail($ventaId);
        return view('checkout.factura', compact('venta'));
    }

    public function descargarFactura($ventaId)
    {
        $venta = Venta::with(['usuario', 'envio'])->findOrFail($ventaId);
        $pdf = Pdf::loadView('checkout.factura-pdf', compact('venta'));
        return $pdf->download('factura-' . $venta->id . '.pdf');
    }
}