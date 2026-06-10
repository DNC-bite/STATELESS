<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\ProductoImagen;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
{
    $query = Producto::with(['categoria', 'proveedor']);

    switch($request->filtro) {
        case 'stock_bajo':
            $query->whereColumn('stock_actual', '<=', 'stock_minimo');
            break;
        case 'sin_stock':
            $query->where('stock_actual', 0);
            break;
        case 'activo':
            $query->where('estado', 'activo');
            break;
        case 'inactivo':
            $query->where('estado', 'inactivo');
            break;
    }

    $productos = $query->get();
    return view('admin.productos.index', compact('productos'));
}

    public function create()
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('admin.productos.create', compact('categorias', 'proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'precio'       => 'required|numeric|min:0',
            'estado'       => 'required|string',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'stock_maximo' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedores,id',
        ]);

        $producto = Producto::create($request->all());

        // Guardar imágenes adicionales
        if ($request->imagenes) {
            foreach ($request->imagenes as $index => $imagen) {
                if ($imagen) {
                    ProductoImagen::create([
                        'producto_id' => $producto->id,
                        'imagen'      => $imagen,
                        'orden'       => $index,
                    ]);
                }
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function show($id)
    {
        $producto = Producto::with(['categoria', 'proveedor', 'imagenes'])->findOrFail($id);
        $relacionados = Producto::where('categoria_id', $producto->categoria_id)
            ->where('id', '!=', $producto->id)
            ->take(3)->get();
        return view('producto.show', compact('producto', 'relacionados'));
    }

    public function edit($id)
    {
        $producto = Producto::with('imagenes')->findOrFail($id);
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('admin.productos.edit', compact('producto', 'categorias', 'proveedores'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'precio'       => 'required|numeric|min:0',
            'estado'       => 'required|string',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'stock_maximo' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedores,id',
        ]);

        $producto->update($request->all());

        // Actualizar imágenes adicionales
        if ($request->imagenes) {
            $producto->imagenes()->delete();
            foreach ($request->imagenes as $index => $imagen) {
                if ($imagen) {
                    ProductoImagen::create([
                        'producto_id' => $producto->id,
                        'imagen'      => $imagen,
                        'orden'       => $index,
                    ]);
                }
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}