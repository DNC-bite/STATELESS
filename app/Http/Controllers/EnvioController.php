<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Venta;
use Illuminate\Http\Request;

class EnvioController extends Controller
{
    public function index()
    {
        $envios = Envio::with('venta')->get();
        $totalEnvios = $envios->count();
        $enviosPendientes = $envios->where('estado', 'pendiente')->count();
        $enviosEnCurso = $envios->where('estado', 'en_curso')->count();
        return view('admin.envios.index', compact('envios', 'totalEnvios', 'enviosPendientes', 'enviosEnCurso'));
    }

    public function create()
    {
        $ventas = Venta::all();
        return view('admin.envios.create', compact('ventas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'venta_id'    => 'required|exists:ventas,id',
            'fecha_envio' => 'nullable|date',
            'direccion'   => 'required|string|max:255',
            'ciudad'      => 'required|string|max:100',
            'estado'      => 'required|string',
        ]);

        Envio::create($request->all());
        return redirect()->route('envios.index')->with('success', 'Envío registrado correctamente.');
    }

    public function edit($id)
    {
        $envio = Envio::findOrFail($id);
        $ventas = Venta::all();
        return view('admin.envios.edit', compact('envio', 'ventas'));
    }

    public function update(Request $request, $id)
    {
        $envio = Envio::findOrFail($id);
        $request->validate([
            'venta_id'    => 'required|exists:ventas,id',
            'fecha_envio' => 'nullable|date',
            'direccion'   => 'required|string|max:255',
            'ciudad'      => 'required|string|max:100',
            'estado'      => 'required|string',
        ]);

        $envio->update($request->all());
        return redirect()->route('envios.index')->with('success', 'Envío actualizado correctamente.');
    }

    public function destroy($id)
    {
        $envio = Envio::findOrFail($id);
        $envio->delete();
        return redirect()->route('envios.index')->with('success', 'Envío eliminado correctamente.');
    }
}