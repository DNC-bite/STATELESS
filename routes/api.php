<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\Api\PedidoApiController;

// Rutas públicas
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::get('/productos', [ProductoApiController::class, 'index']);
Route::get('/productos/{id}', [ProductoApiController::class, 'show']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/usuario', [AuthApiController::class, 'usuario']);
    Route::get('/mis-pedidos', [PedidoApiController::class, 'index']);
});