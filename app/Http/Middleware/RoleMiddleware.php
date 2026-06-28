<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): mixed
{
    $response = $next($request);
    $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', '0');

    if (!auth()->check()) {
        return redirect('/login');
    }

    if (auth()->user()->role->name !== $role) {
        abort(403, 'No tienes permiso para acceder aquí.');
    }

    return $response;
}
}

