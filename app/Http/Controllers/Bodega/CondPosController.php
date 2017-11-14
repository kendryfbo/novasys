<?php

namespace App\Http\Controllers\Bodega;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Familia;
use App\Models\TipoFamilia;
use Illuminate\Http\Request;
use App\Models\Bodega\PosCond;
use App\Models\Bodega\PosCondTipo;
use App\Http\Controllers\Controller;

class CondPosController extends Controller
{

    public function store(Request $request) {

        $posicion_id = $request->posicion_id;
        $tipo_id = $request->tipo_id;
        $opcion_id = $request->opcion_id;

        try {

            if ( (!$posicion_id) ) {

                return response(404);
            }

            if ((!$tipo_id) && (!$opcion_id)) {

                PosCond::where('posicion_id',$posicion_id)->delete();

                return response('Ok',200);
            }

            $condicion = PosCond::where('posicion_id',$posicion_id)->first();

            if ($condicion) {

                $condicion->delete();
            }

            PosCond::create([
                'posicion_id' => $posicion_id,
                'tipo_id' => $tipo_id,
                'opcion_id' => $opcion_id,
                'activo' => 1
            ]);

            return response('Ok',200);

        } catch (Exception $e) {

            dd($e);
        }

    }

    public function getOpcionesFromTipo($condicion) {

        $opciones = [];

        // CONDICION PARA PRODUCTO ESPECIFICO
        if ($condicion == 4) {

            $opciones = Producto::getAllActive();
        }
        // CONDICION PARA MARCA ESPECIFICO
        if ($condicion == 3) {

            $opciones = Marca::getAllActive();
        }
        // CONDICION PARA FAMILIA ESPECIFICO
        if ($condicion == 2) {

            $opciones = Familia::getAllActive();
        }
        // CONDICION PARA TIPO DE FAMLIA ESPECIFICO
        if ($condicion == 1) {

            $opciones = TipoFamilia::getAllActive();
        }

        return response($opciones,200);
    }

    public function getCondicionOfPos($posicion) {

        $condicion = PosCond::where('posicion_id',$posicion)->first();

        if($condicion) {

            return response($condicion,200);
        }

        response(200);
    }
}
