<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    // Ver carrito
    public function index()
    {
        $carrito = Carrito::with('items.producto')
            ->firstOrCreate(['user_id' => Auth::id()]);

        return view('carrito.index', compact('carrito'));
    }

public function agregar(Request $request, $productoId)
{
    $producto = Producto::findOrFail($productoId);
    $carrito = Carrito::firstOrCreate(['user_id' => Auth::id()]);
    $item = $carrito->items()->where('producto_id', $productoId)->first();

    if ($item) {
        $item->increment('cantidad');
    } else {
        $carrito->items()->create([
            'producto_id'     => $producto->id,
            'cantidad'        => 1,
            'precio_unitario' => $producto->precio,
        ]);
    }

    $cantidad = $carrito->items()->sum('cantidad');

    return response()->json([
        'success'  => true,
        'cantidad' => $cantidad,
    ]);
}

    // Actualizar cantidad
    public function actualizar(Request $request, $itemId)
    {
        $item = CarritoItem::findOrFail($itemId);

        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $item->update(['cantidad' => $request->cantidad]);

        return redirect()->route('carrito.index')->with('success', 'Carrito actualizado.');
    }

    // Eliminar item
    public function eliminar($itemId)
    {
        $item = CarritoItem::findOrFail($itemId);
        $item->delete();

        return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito.');
    }

    // Vaciar carrito
    public function vaciar()
    {
        $carrito = Carrito::where('user_id', Auth::id())->first();

        if ($carrito) {
            $carrito->items()->delete();
        }

        return redirect()->route('carrito.index')->with('success', 'Carrito vaciado.');
    }
}