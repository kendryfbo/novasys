<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Log;
use DB;
use Route;

class Acceso extends Model
{
    protected $fillable = ['nombre', 'modulo', 'controller', 'action'];

    static function getAllAccessOfPerfil($id) {

		$query = "SELECT id,nombre,modulo,controller,action,
                    IFNULL((SELECT perfil_accesos.acceso from perfil_accesos where accesos.id=perfil_accesos.acceso_id and perfil_id=".$id."),0)
                    AS access FROM accesos";
		$results = DB::select(DB::raw($query));
        
        if (!$results) {

            return 0;
        }
        return $results;
	}

    static function arrayOfAccess() {

        $accesos = Acceso::where('padre','root')->get()->toArray();
        // dd($accesos);
        $accesos = self::getChildrens($accesos);

          dd($accesos);
    }

    static private function getChildrens($padres) {

        $i = 0;
        foreach($padres as $padre) {

            $hijos = Acceso::where('padre',$padre['id'])->get()->toArray();

            $padres[$i]['hijos'] = self::getChildrens($hijos);
        $i++;
        }
        return $padres;
    }

    static function registerAccesos() {

        $routes = Route::getRoutes();

        foreach ($routes as $route) {

            // Nombre de Controlador
            $controller = (explode('@', $route->getActionName()));
            $controller = preg_replace('/.*\\\/', '', $controller);
            $controller = $controller[0];
            // Nombre de Modulo
            $prefix = trim($route->getPrefix());
            $prefix = explode('/',$prefix);
            $prefix = array_filter($prefix, function($value) { return $value !== ''; });
            $prefix = array_slice($prefix,0);
            if (!$prefix) {
                $prefix = 'main';
            } else {
                $prefix = $prefix[0];
            }
            //Nombre de Ruta
            $nombre = $route->getName();
            // Nombre de funcion o Accion
            $action = $route->getActionMethod();

            $acceso = Acceso::where('nombre',$nombre)
                            ->where('modulo',$prefix)
                            ->where('controller',$controller)
                            ->where('action',$action)
                            ->first();

            if (!$acceso && $nombre) {

                Acceso::create([
                    'nombre' => $nombre,
                    'modulo' => $prefix,
                    'controller' => $controller,
                    'action' => $action
                ]);
            }
        }

    }
}
