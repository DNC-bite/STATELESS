<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\Api\PedidoApiController;

// ── Rutas públicas ──────────────────────────────────────────
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);

Route::get('/productos', [ProductoApiController::class, 'index']);
Route::get('/productos/{id}', [ProductoApiController::class, 'show']);

Route::get('/imagen/{filename}', function ($filename) {
    $path = public_path('images/' . $filename);
    if (!file_exists($path)) {
        return response()->json(['error' => 'No encontrada'], 404);
    }
    return response()->file($path, [
        'Access-Control-Allow-Origin' => '*',
    ]);
})->where('filename', '.*');

// ── Rutas protegidas ────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/usuario', function (Request $request) {
        return response()->json($request->user());
    });
    Route::get('/mis-pedidos', function (Request $request) {
        $pedidos = $request->user()->ventas()->with('envio')->latest()->get();
        return response()->json(['data' => $pedidos]);
    });
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada']);
    });
});