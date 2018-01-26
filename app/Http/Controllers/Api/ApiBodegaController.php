<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Log;
use App\Models\Bodega\Bodega;
use App\Models\Bodega\PosicionStatus;

class ApiBodegaController extends Controller
{
    public function asd(){
        return 'hola';
    }

    public function getBodegasWithPos() {

        try {
            $disponible = PosicionStatus::disponible();

            $bodegas = Bodega::with(['posiciones' => function($posiciones) use($disponible){
                $posiciones->where('status_id',$disponible->id);
            }])->get();

            return response()->json($bodegas,200);

        } catch (QueryException $e) {

            Log::critical("DB-ERROR - No se pudo realizar la busqueda de Bodegas: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("APP-ERROR - No se pudo realizar la busqueda de Bodegas: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMEssage(),500);
        }
    }

    public function getPositionsFrom(Request $request) {

        try {

            $bodegaId = $request->bodegaId;
            $bloques = Bodega::getPositions($bodegaId);

            return response($bloques,200);

        } catch (\Exception $e) {

            return response($e,404);
        }

    }
}
