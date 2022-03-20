<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch (Auth::user()->tipoUsuario()) {
                case 'R':
                    return redirect()->route('inicio.responsable');
                    break;
                case 'D':
                    return redirect()->route('inicio.docencia');
                    break;
                case 'A':
                    return redirect()->route('inicio.alumno');
                    break;
                default:
                    return redirect('error-404');
                    break;
            }
        }

        return $next($request);
    }
}
