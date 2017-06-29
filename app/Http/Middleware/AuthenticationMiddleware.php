<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Comentar para habilitar autenticacion
        // return $next($request);

        if ($request->user() === null) {

            return redirect()->guest('ingresar');
        }

        // Comentar para habilitar autorizacion
        return $next($request);

        $actions = $request->route()->getAction();
        $acceso = isset($actions['prefix']) ? $actions['prefix'] : null;

        if( $request->user()->haveAccessTo($acceso) || !$acceso ) {

          return $next($request);
        }
        return response('Acceso No Autorizado',401);
    }
}
