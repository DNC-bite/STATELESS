<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Http\Request;

class PedidoApiController extends Controller
{
    public function index(Request $request)
    {
        $pedidos = Venta::with('envio')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->map(fn($v) => [
                'id'           => $v->id,
                'tipo_venta'   => $v->tipo_venta,
                'metodo_pago'  => $v->metodo_pago,
                'total'        => $v->total,
                'codigo_pago'  => $v->codigo_pago,
                'created_at'   => $v->created_at->format('d/m/Y H:i'),
                'envio'        => $v->envio ? [
                    'estado'    => $v->envio->estado,
                    'direccion' => $v->envio->direccion,
                    'ciudad'    => $v->envio->ciudad,
                ] : null,
            ]);

        return response()->json(['data' => $pedidos]);
    }
}