<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\CarritoController;
use App\Models\Producto;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReporteController;

// Dentro del grupo admin
Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('/reportes/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
Route::get('/reportes/inventario', [ReporteController::class, 'inventario'])->name('reportes.inventario');
Route::get('/reportes/envios', [ReporteController::class, 'envios'])->name('reportes.envios');
Route::get('/reportes/proveedores', [ReporteController::class, 'proveedores'])->name('reportes.proveedores');

// Dentro del grupo admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // ... resto de rutas
});

Route::get('/account', function () {
    return view('account.index');
})->middleware(['auth', 'verified'])->name('account'); // ← agrega 'verified'

Route::get('/producto/{producto}', [ProductoController::class, 'show'])->name('producto.show');

// Ruta principal
Route::get('/', function () {
    $essentials = Producto::where('estado', 'activo')
        ->whereHas('categoria', fn($q) => $q->where('nombre', 'Essentials'))
        ->get();

    return view('welcome', compact('essentials'));
});

// Rutas de colecciones
Route::get('/essentials', function () {
    $essentials = Producto::where('estado', 'activo')
        ->whereHas('categoria', fn($q) => $q->where('nombre', 'Essentials'))
        ->get();
    return view('ecomerce.essentials', compact('essentials'));
})->name('essentials');

Route::get('/octane', function () {
    $octane = Producto::where('estado', 'activo')
        ->whereHas('categoria', fn($q) => $q->where('nombre', 'Octane'))
        ->get();
    return view('ecomerce.octane', compact('octane'));
})->name('octane');
Route::get('/waves', function () {
    $waves = Producto::where('estado', 'activo')
        ->whereHas('categoria', fn($q) => $q->where('nombre', 'Waves'))
        ->get();
    return view('ecomerce.waves', compact('waves'));
})->name('waves');
// Carrito
Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::patch('/carrito/actualizar/{item}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/eliminar/{item}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::delete('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
}); 

// Checkout
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/procesar', [CheckoutController::class, 'procesar'])->name('checkout.procesar');
    Route::get('/checkout/factura/{venta}', [CheckoutController::class, 'factura'])->name('checkout.factura');
    Route::get('/checkout/factura/{venta}/descargar', [CheckoutController::class, 'descargarFactura'])->name('checkout.descargar');
});
// Ruta PSE
Route::middleware('auth')->group(function () {
    Route::get('/checkout/pse/{venta}', [CheckoutController::class, 'pse'])->name('checkout.pse');
    Route::post('/checkout/pse/{venta}/confirmar', [CheckoutController::class, 'confirmarPse'])->name('checkout.pse.confirmar');
});

// Dashboard
Route::get('/dashboard', function () {
    return redirect()->route('account');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('usuarios', UserController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('envios', EnvioController::class);
});

// Rutas Empleado
Route::middleware(['auth', 'role:empleado'])->prefix('empleado')->name('empleado.')->group(function () {
    Route::resource('ventas', VentaController::class);
    Route::resource('envios', EnvioController::class);
    Route::resource('proveedores', ProveedorController::class);
});

// Autenticación
require __DIR__.'/auth.php';

Route::get('/account', function () {
    return view('account.index');
})->middleware('auth')->name('account');