<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Login
Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }
    $token = $user->createToken('mobile')->plainTextToken;
    return response()->json(['token' => $token, 'user' => $user]);
});

// ← FUERA del grupo auth: ruta pública de imágenes
Route::get('/imagen/{filename}', function ($filename) {
    $path = public_path('images/' . $filename);
    if (!file_exists($path)) {
        return response()->json(['error' => 'No encontrada'], 404);
    }
    return response()->file($path, [
        'Access-Control-Allow-Origin' => '*',
    ]);
})->where('filename', '.*');

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/usuario', function (Request $request) {
        return response()->json($request->user());
    });
    Route::get('/mis-pedidos', function (Request $request) {
        $pedidos = $request->user()->ventas()->with('envio')->latest()->get();
        return response()->json(['data' => $pedidos]);
    });
    Route::get('/productos', function (Request $request) {
        $productos = \App\Models\Producto::where('estado', 'activo')->with('categoria')->get();
        return response()->json(['data' => $productos]);
    });
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada']);
    });
});