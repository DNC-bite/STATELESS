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

Route::get('/producto/{producto}', [ProductoController::class, 'show'])->name('producto.show');

// Ruta Essentials
Route::get('/essentials', function () {
    $essentials = Producto::where('estado', 'activo')
        ->whereHas('categoria', fn($q) => $q->where('nombre', 'Essentials'))
        ->get();

    return view('ecommerce.essentials', compact('essentials'));
})->name('essentials');

// Ruta The Chroma Life
Route::get('/chroma-life', function () {
    $chromaLife = Producto::where('estado', 'activo')
        ->whereHas('categoria', fn($q) => $q->where('nombre', 'The Chroma Life'))
        ->get();

    return view('ecommerce.chroma-life', compact('chromaLife'));
})->name('chroma-life');

// Ruta principal
Route::get('/', function () {
    $essentials = Producto::where('estado', 'activo')
        ->whereHas('categoria', fn($q) => $q->where('nombre', 'Essentials'))
        ->take(3)->get();

    $chromaLife = Producto::where('estado', 'activo')
        ->whereHas('categoria', fn($q) => $q->where('nombre', 'The Chroma Life'))
        ->take(3)->get();

    return view('welcome', compact('essentials', 'chromaLife'));
});
// Carrito
Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::patch('/carrito/actualizar/{item}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/eliminar/{item}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::delete('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
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