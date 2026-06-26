<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('items.producto')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('account.pedidos', compact('ventas'));
    }
}