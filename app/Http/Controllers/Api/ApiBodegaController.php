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
    public function getBodegasPosWithPallet(Request $request) {

        try {
            $disponible = PosicionStatus::ocupado();

            $bodegas = Bodega::with(['posiciones' => function($posiciones) use($disponible){
                $posiciones->where('status_id',$disponible->id)->whereNotNull('pallet_id');
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

    public function getExistTipoFromBodega(Request $request) {

        $bodegaID = $request->bodegaID;
        $tipoProdID = $request->tipoID;

        if (!$bodegaID || !$tipoProdID) {
            return response('Faltan datos',404);
        }

        try {
            $productos = Bodega::getStockByTipoFromBodega($bodegaID,$tipoProdID);

            return response()->json($productos,200);

        } catch (QueryException $e) {

            Log::critical("DB-ERROR - No se pudo realizar la busqueda de Bodegas: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");
            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("APP-ERROR - No se pudo realizar la busqueda de Bodegas: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");
            return response($e->getMEssage(),500);
        }
    }

    public function consult(Request $request) {

        $bodegaID = $request->bodegaID;

        if (!$bodegaID) {
            return response('Faltan datos',404);
        }

        try {
            $bloques = Bodega::getPositions($bodegaID);

            return response()->json($bloques,200);

        } catch (QueryException $e) {

            Log::critical("DB-ERROR - No se pudo realizar consulta de bloques en bodega: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");
            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("APP-ERROR - No se pudo realizar consulta de bloques en bodega: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");
            return response($e->getMEssage(),500);
        }
    }

    public function blockBodegaPosition(Request $request) {

        $posicionID = $request->posicionID;

        if (!$posicionID) {
            return response('Faltan datos',404);
        }

        try {
            $position = Bodega::blockPosition($posicionID);

            return response()->json($position,200);
        } catch (QueryException $e) {

            Log::critical("DB-ERROR - No se pudo realizar el bloqueo de posicion: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");
            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("APP-ERROR - No se pudo realizar el bloqueo de posicion: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");
            return response($e->getMEssage(),500);
        }
    }
    public function unBlockBodegaPosition(Request $request) {

        $posicionID = $request->posicionID;

        if (!$posicionID) {
            return response('Faltan datos',404);
        }

        try {
            $position = Bodega::unBlockPosition($posicionID);

            return response()->json($position,200);
        } catch (QueryException $e) {

            Log::critical("DB-ERROR - No se pudo realizar el bloqueo de posicion: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");
            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("APP-ERROR - No se pudo realizar el bloqueo de posicion: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");
            return response($e->getMEssage(),500);
        }
    }
}
