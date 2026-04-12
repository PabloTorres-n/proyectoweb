<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSersionToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
  public function handle(Request $request, Closure $next)
{
    // Si NO existe el token o el user_id en la sesión...
    if (!session()->has('token') || !session()->has('user_id')) {
        // ... lo mandamos al login con un mensaje
        return redirect()->route('login')->with('error', 'Sesión expirada o inválida.');
    }

    return $next($request);
}
}
