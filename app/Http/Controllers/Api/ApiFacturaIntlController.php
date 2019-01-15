<?php

namespace App\Http\Controllers\Api;

use App\Models\Comercial\FacturaIntl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ApiFacturaIntlController extends Controller
{

    public static function getFacturaIntlByClient(Request $request) {

        try {

            $clienteId = $request->clienteId;
            $facturas = FacturaIntl::where('cliente_id', $clienteId)->get();
            return response()->json($facturas,200);

            } catch (Exception $e) {

            return response('Facturas No Encontradas',404);
        }
    }

    public static function getHistorialIntlByClient(Request $request) {

        try {

            $clienteId = $request->clienteId;
            $facturas = FacturaIntl::where('cliente_id', $clienteId)->get();
            return response()->json($facturas,200);

            } catch (Exception $e) {

            return response('Facturas No Encontradas',404);
        }
    }

    public static function getFacturasPorCobrar(Request $request) {

        try {

            $clienteId = $request->clienteId;
            $facturas = FacturaIntl::where('cliente_id', $clienteId)->get();
            return response()->json($facturas,200);

            } catch (Exception $e) {

            return response('Facturas No Encontradas',404);
        }
    }

    public static function getFacturaPorAnular(Request $request) {

        try {

            $clienteId = $request->clienteId;
            $facturas = FacturaIntl::where('cliente_id', $clienteId)->get();
            return response()->json($facturas,200);

            } catch (Exception $e) {

            return response('Facturas No Encontradas',404);
        }
    }

}
