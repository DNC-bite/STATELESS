<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\User;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('usuario')->get();
        $total = $ventas->sum('total');
        $ventasFisicas = $ventas->where('tipo_venta', 'fisica')->sum('total');
        $ventasOnline = $ventas->where('tipo_venta', 'online')->sum('total');
        return view('admin.ventas.index', compact('ventas', 'total', 'ventasFisicas', 'ventasOnline'));
    }

    public function create()
    {
        $usuarios = User::all();
        return view('admin.ventas.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_venta'   => 'required|string',
            'metodo_pago'  => 'required|string',
            'total'        => 'required|numeric|min:0',
            'user_id'      => 'required|exists:users,id',
        ]);

        Venta::create($request->all());
        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function edit($id)
    {
        $venta = Venta::findOrFail($id);
        $usuarios = User::all();
        return view('admin.ventas.edit', compact('venta', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);
        $request->validate([
            'tipo_venta'   => 'required|string',
            'metodo_pago'  => 'required|string',
            'total'        => 'required|numeric|min:0',
            'user_id'      => 'required|exists:users,id',
        ]);

        $venta->update($request->all());
        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }
}