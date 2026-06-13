<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\User;
use App\Models\Envio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Estadísticas generales
        $totalVentas = Venta::sum('total');
        $totalPedidos = Venta::count();
        $totalClientes = User::whereHas('role', fn($q) => $q->where('name', 'cliente'))->count();
        $totalProductos = Producto::count();

        // Ventas por día (último mes)
        $ventasPorDia = [];
        $labelsDias = [];
        for ($i = 29; $i >= 0; $i--) {
            $dia = Carbon::now()->subDays($i);
            $labelsDias[] = $dia->format('d/m');
            $ventasPorDia[] = Venta::whereDate('created_at', $dia->toDateString())->sum('total');
        }

        // Productos más vendidos
        $productosMasVendidos = Producto::withCount(['carritoItems as total_vendido' => function($q) {
            $q->whereHas('carrito', fn($c) => $c->whereNotNull('user_id'));
        }])->orderBy('total_vendido', 'desc')->take(5)->get();

        // Ventas por método de pago
        $ventasPorMetodo = Venta::selectRaw('metodo_pago, COUNT(*) as total')
            ->groupBy('metodo_pago')
            ->get();

        // Ventas recientes
        $ventasRecientes = Venta::with('usuario')->latest()->take(5)->get();

        // Stock bajo
        $stockBajo = Producto::whereColumn('stock_actual', '<=', 'stock_minimo')->count();

        // Envíos pendientes
        $enviosPendientes = Envio::where('estado', 'pendiente')->count();

        return view('admin.dashboard', compact(
        'totalVentas', 'totalPedidos', 'totalClientes', 'totalProductos',
        'ventasPorDia', 'labelsDias', 'productosMasVendidos',
        'ventasPorMetodo', 'ventasRecientes', 'stockBajo', 'enviosPendientes'
    ));
    }
}