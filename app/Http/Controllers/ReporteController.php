<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Envio;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        return view('admin.reportes.index');
    }

    public function ventas(Request $request)
    {
        $desde = $request->desde ? Carbon::parse($request->desde) : Carbon::now()->startOfMonth();
        $hasta = $request->hasta ? Carbon::parse($request->hasta) : Carbon::now();

        $ventas = Venta::with(['usuario', 'envio'])
            ->whereBetween('created_at', [$desde, $hasta->endOfDay()])
            ->get();

        $totalVentas = $ventas->sum('total');
        $totalPedidos = $ventas->count();
        $ventasFisicas = $ventas->where('tipo_venta', 'fisica')->sum('total');
        $ventasOnline = $ventas->where('tipo_venta', 'online')->sum('total');

        $porMetodo = $ventas->groupBy('metodo_pago')->map(fn($g) => [
            'cantidad' => $g->count(),
            'total'    => $g->sum('total'),
        ]);

        return view('admin.reportes.ventas', compact(
            'ventas', 'totalVentas', 'totalPedidos',
            'ventasFisicas', 'ventasOnline', 'porMetodo',
            'desde', 'hasta'
        ));
    }

    public function inventario()
    {
        $productos = Producto::with('categoria')->get();
        $totalProductos = $productos->count();
        $stockBajo = $productos->filter(fn($p) => $p->stock_actual <= $p->stock_minimo)->count();
        $sinStock = $productos->where('stock_actual', 0)->count();
        $valorInventario = $productos->sum(fn($p) => $p->precio * $p->stock_actual);

        return view('admin.reportes.inventario', compact(
            'productos', 'totalProductos', 'stockBajo', 'sinStock', 'valorInventario'
        ));
    }

    public function envios()
    {
        $envios = Envio::with('venta.usuario')->get();
        $totalEnvios = $envios->count();
        $pendientes = $envios->where('estado', 'pendiente')->count();
        $enCurso = $envios->where('estado', 'en_curso')->count();
        $entregados = $envios->where('estado', 'entregado')->count();

        return view('admin.reportes.envios', compact(
            'envios', 'totalEnvios', 'pendientes', 'enCurso', 'entregados'
        ));
    }

    public function proveedores()
    {
        $proveedores = Proveedor::with('productos')->get();
        $totalProveedores = $proveedores->count();
        $activos = $proveedores->where('estado', 1)->count();
        $inactivos = $proveedores->where('estado', 0)->count();

        return view('admin.reportes.proveedores', compact(
            'proveedores', 'totalProveedores', 'activos', 'inactivos'
        ));
    }
}