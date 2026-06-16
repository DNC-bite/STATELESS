<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Venta;
use App\Models\Envio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

class CheckoutController extends Controller
{
    public function index()
    {
        $carrito = Carrito::with('items.producto')
            ->where('user_id', Auth::id())
            ->first();

        if (!$carrito || $carrito->items->isEmpty()) {
            return redirect()->route('carrito.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        return view('checkout.index', [
            'carrito' => $carrito,
        ]);
    }

    public function procesar(Request $request)
    {
        $request->validate([
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:100',
            'metodo_pago' => 'required|string',
        ]);

        $carrito = Carrito::with('items.producto')
            ->where('user_id', Auth::id())
            ->first();

        if (!$carrito || $carrito->items->isEmpty()) {
            return response()->json([
                'error' => 'Carrito vacío'
            ], 400);
        }

        MercadoPagoConfig::setAccessToken(
            config('services.mercadopago.access_token')
        );

        $items = [];

        foreach ($carrito->items as $item) {
            $items[] = [
                'title' => $item->producto->nombre,
                'quantity' => (int)$item->cantidad,
                'unit_price' => (float)$item->producto->precio,
                'currency_id' => 'COP',
            ];
        }

        try {

            $client = new PreferenceClient();

            $preference = $client->create([
                'items' => $items,
            ]);

            return response()->json([
                'init_point' => $preference->init_point,
            ]);
        } catch (\Exception $e) {

            dd(
                'ERROR MERCADO PAGO',
                $e->getMessage()
            );
        }
    }

    // Mercado Pago llama aquí cuando confirma el pago
    public function webhook(Request $request)
    {
        Log::info('Webhook MP recibido', $request->all());

        if ($request->type !== 'payment') {
            return response()->json(['status' => 'ignored'], 200);
        }

        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

        $paymentClient = new PaymentClient();
        $payment = $paymentClient->get($request->data['id']);

        if ($payment->status !== 'approved') {
            return response()->json(['status' => 'not approved'], 200);
        }

        $meta = $payment->metadata;

        $carrito = Carrito::with('items.producto')
            ->find($meta->carrito_id);

        if (!$carrito || $carrito->items->isEmpty()) {
            return response()->json(['status' => 'carrito no encontrado'], 200);
        }

        // Evitar procesar dos veces el mismo pago
        if (Venta::where('payment_id', $payment->id)->exists()) {
            return response()->json(['status' => 'ya procesado'], 200);
        }

        // Crear venta
        $venta = Venta::create([
            'tipo_venta'  => 'online',
            'metodo_pago' => $meta->metodo_pago ?? 'mercadopago',
            'total'       => $payment->transaction_amount,
            'user_id'     => $meta->user_id,
            'payment_id'  => $payment->id,
        ]);

        $venta->update(['estado_pago' => 'approved']);


        // Crear envío
        Envio::create([
            'venta_id'  => $venta->id,
            'direccion' => $meta->direccion,
            'ciudad'    => $meta->ciudad,
            'estado'    => 'pendiente',
        ]);

        // Descontar stock
        foreach ($carrito->items as $item) {
            $item->producto->decrement('stock_actual', $item->cantidad);
        }

        // Vaciar carrito
        $carrito->items()->delete();

        return response()->json(['status' => 'ok'], 200);
    }

    public function exito(Request $request)
    {
        // MP redirige aquí con payment_id en la URL
        $paymentId = $request->payment_id;
        $venta = Venta::where('payment_id', $paymentId)->first();

        if ($venta) {
            return redirect()->route('checkout.factura', $venta->id);
        }

        // Si el webhook aún no procesó, mostrar pantalla de espera
        return view('checkout.procesando');
    }

    public function pendiente()
    {
        return view('checkout.pendiente');
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
