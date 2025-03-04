<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperMiddleware
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
        // Verifica si el usuario está autenticado y tiene el tipo de 'oper'
        if (Auth::check() && Auth::user()->type === 'oper') {
            return $next($request);
        }

        // Si no es operario, genera un error HTTP 404
        abort(404, 'No puedes pasar');
    }
}
