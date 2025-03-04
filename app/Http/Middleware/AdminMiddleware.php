<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado y tiene el tipo de 'admin'
        if (Auth::check() && Auth::user()->type === 'admin') {
            return $next($request);
        }

        // Si no es admin, genera un error HTTP 404
        abort(404, 'No puedes pasar');
    }
}
