<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Config\Acceso;
use App\Models\Config\PerfilAcceso;

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

        if ($request->user() === null || !$request->user()->activo ) {

            return redirect()->guest('ingresar');
        }

        // Comentar para habilitar autorizacion
        return $next($request);

        $actions = (explode('@', $request->route()->getActionName()));
        $actions = preg_replace('/.*\\\/', '', $actions);
        dd($actions);
        $controllerName = $actions[0];
        $actionName = $actions[1];

        $perfil_id = $request->user()->perfil->id;
        $acceso_id = Acceso::where('controller',$controllerName)->where('action',$actionName)->pluck('id')->first();
        $acceso = PerfilAcceso::where('perfil_id',$perfil_id)->where('acceso_id',$acceso_id)->pluck('acceso')->first();
        if ($acceso) {

            return $next($request);
        } else {

            return response('Acceso No Autorizado',401);
        }
    }
}
