<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductoVariante;
use Illuminate\Http\Request;

class VarianteController extends Controller
{
    public function store(Request $request, Producto $producto)
    {
        $request->validate([
            'color'        => 'required|string|max:100',
            'hex'          => 'nullable|string|max:7',
            'imagen'       => 'nullable|string',
            'stock_actual' => 'required|integer|min:0',
        ]);

        ProductoVariante::create([
            'producto_id'  => $producto->id,
            'color'        => $request->color,
            'hex'          => $request->hex,
            'imagen'       => $request->imagen ?: null,
            'stock_actual' => $request->stock_actual,
        ]);

        return redirect()->route('productos.edit', $producto)
            ->with('success', 'Variante agregada correctamente.');
    }

    public function destroy(ProductoVariante $variante)
    {
        $productoId = $variante->producto_id;
        $variante->delete();
        return redirect()->route('productos.edit', $productoId)
            ->with('success', 'Variante eliminada.');
    }
}