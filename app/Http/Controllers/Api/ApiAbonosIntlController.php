<?php

namespace App\Http\Controllers\Api;

use App\Models\Finanzas\AbonosIntl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ApiAbonosIntlController extends Controller
{

    public static function getAbonoIntlByClient(Request $request) {

        try {

            $clienteId = $request->clienteId;
            $abonos = AbonosIntl::where('cliente_id', $clienteId)->get();
            return response()->json($abonos,200);

            } catch (Exception $e) {

            return response('Facturas No Encontradas',404);
        }
    }
}
