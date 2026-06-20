<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class ProductoApiController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['categoria', 'imagenes'])
            ->where('estado', 'activo')
            ->get()
            ->map(fn($p) => [
                'id'          => $p->id,
                'nombre'      => $p->nombre,
                'descripcion' => $p->descripcion,
                'precio'      => $p->precio,
                'imagen'      => $p->imagen,
                'stock_actual'=> $p->stock_actual,
                'estado'      => $p->estado,
                'categoria'   => $p->categoria ? ['nombre' => $p->categoria->nombre] : null,
                'imagenes'    => $p->imagenes->map(fn($i) => $i->imagen),
            ]);

        return response()->json(['data' => $productos]);
    }

    public function show($id)
    {
        $producto = Producto::with(['categoria', 'imagenes'])->findOrFail($id);

        return response()->json([
            'data' => [
                'id'          => $producto->id,
                'nombre'      => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'precio'      => $producto->precio,
                'imagen'      => $producto->imagen,
                'stock_actual'=> $producto->stock_actual,
                'estado'      => $producto->estado,
                'categoria'   => $producto->categoria ? ['nombre' => $producto->categoria->nombre] : null,
                'imagenes'    => $producto->imagenes->map(fn($i) => $i->imagen),
            ]
        ]);
    }
}