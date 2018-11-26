<?php

namespace App\Http\Controllers\Finanzas;

use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\ClienteIntl;
use App\Models\Comercial\FacturaIntl;
use App\Models\Finanzas\AbonoIntl;


class AbonosIntlController extends Controller
{

    /**
     * Index de Abonos de Clientes Intl
     *
     * @param  \Illuminate\Http\Request  $request
     */

        public function index() {


        //$fecha_hoy = Carbon::now();
        $clientes = ClienteIntl::getAllActive();
        $abonos = AbonoIntl::getAllActive();
        return view('finanzas.abonosIntl.index')->with(['clientes' => $clientes, 'abonos' => $abonos]);
    }



    /**
     * Crea Abono de Cliente Intl
     *
     * @param  \Illuminate\Http\Request  $request
     */

        public function create() {


        $fecha_hoy = Carbon::now();
        $clientes = ClienteIntl::getAllActive();
        return view('finanzas.abonosIntl.create')->with(['clientes' => $clientes, 'fecha_hoy' => $fecha_hoy]);
    }


    /**
     * Guarda Abono de Cliente Intl
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        public function store(Request $request) {

            $abonoIntl = AbonoIntl::create([
                "cliente_id" => $request->input('cliente'),
                "usuario_id" => Auth::user()->id,
                "monto" => $request->input('monto'),
                "restante" => $request->input('monto'),
                "orden_despacho" => $request->input('orden_despacho'),
                "docu_abono" => $request->input('docu_abono'),
                "fecha_abono" => $request->input('fecha_abono'),
                ]);

                $msg = '$ '.$abonoIntl->monto.' fueron abonados a Cliente Nº '.$abonoIntl->clienteIntl->descripcion.' exitosamente.';
                return redirect()->route('crearAbonoIntl')->with(['status' => $msg]);

    }
}
