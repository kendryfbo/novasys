<?php

namespace App\Http\Controllers\Finanzas;

use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\FacturaNacional;
use App\Models\Finanzas\AbonoNacional;


class AbonosNacionalController extends Controller
{

    /**
     * Index de Abonos de Cliente Nacional
     *
     * @param  \Illuminate\Http\Request  $request
     */

        public function index() {

            $clientes = ClienteNacional::getAllActive();
            $abonos = AbonoNacional::getAllActive();
            return view('finanzas.abonosNac.index')->with(['clientes' => $clientes, 'abonos' => $abonos]);

        }


    /**
     * Crea Abono de Cliente Nacional
     *
     * @param  \Illuminate\Http\Request  $request
     */

        public function create() {

            $fecha_hoy = Carbon::now();
            $clientes = ClienteNacional::getAllActive();
            return view('finanzas.abonosNac.create')->with(['clientes' => $clientes, 'fecha_hoy' => $fecha_hoy]);

        }


    /**
     * Guarda Abono de Cliente Nacional
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        public function store(Request $request) {

            $abonoNac = AbonoNacional::create([
                "cliente_id" => $request->input('cliente'),
                "usuario_id" => Auth::user()->id,
                "monto" => $request->input('monto'),
                "restante" => $request->input('monto'),
                "orden_despacho" => $request->input('orden_despacho'),
                "docu_abono" => $request->input('docu_abono'),
                "fecha_abono" => $request->input('fecha_abono'),
                ]);

                $msg = '$ '.$abonoNac->monto.' fueron abonados a Cliente Nº '.$abonoNac->clienteNacional->descripcion.' exitosamente.';
                return redirect()->route('abonosNacional')->with(['status' => $msg]);

        }
}
