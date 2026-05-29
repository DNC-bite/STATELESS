<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): mixed
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->role->name !== $role) {
            abort(403, 'No tienes permiso para acceder aquí.');
        }

        return $next($request);
    }
}

