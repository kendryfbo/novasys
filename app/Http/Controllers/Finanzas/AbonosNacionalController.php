<?php

namespace App\Http\Controllers\Finanzas;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Finanzas\Bancos;
use App\Models\Finanzas\FormaPago;
use App\Http\Controllers\Controller;
use App\Models\Finanzas\AbonoNacional;
use App\Models\Finanzas\ChequeCartera;
use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\FacturaNacional;


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
            $bancos = Bancos::getAllActive();
            $formasPago = FormaPago::getAllActive();
            return view('finanzas.abonosNac.create')->with(['clientes' => $clientes, 'fecha_hoy' => $fecha_hoy, 'bancos' => $bancos, 'formasPago' => $formasPago]);

        }


    /**
     * Guarda Abono de Cliente Nacional
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        public function store(Request $request) {
            //dd($request);
            $abonoNac = AbonoNacional::create([
                "cliente_id" => $request->input('cliente'),
                "usuario_id" => Auth::user()->id,
                "monto" => $request->input('monto'),
                "restante" => $request->input('monto'),
                "orden_despacho" => $request->input('orden_despacho'),
                "docu_abono" => $request->input('docu_abono'),
                "fecha_abono" => $request->input('fecha_abono'),
                "formaPago_id" => $request->input('forma_pago'),
                "banco_id" => $request->input('banco'),
                "fecha_cobro" => $request->input('fecha_cobro'),

                ]);

                //Si cliente paga con cheque se guarda Cheque en Cartera
                $formaPago = $request->input('forma_pago');
                $cliente = $request->input('cliente');
                $banco = $request->input('banco');
                $numero = $request->input('docu_abono');
                $monto = $request->input('monto');
                $fechaCobro = $request->input('fecha_cobro');
                $chequeAlDia = FormaPago::getChequeDiaID();
                $chequeAFecha = FormaPago::getChequeFechaID();
                
                if ($formaPago == $chequeAlDia || $formaPago == $chequeAFecha) {

                    ChequeCartera::create([
              				  'cliente_id' => $cliente,
                              'banco_id' => $banco,
                              'abono_id' => Carbon::now()->format('YmdHis'),
                              'numero_cheque' => $numero,
                              'monto' => $monto,
              				  'fecha_cobro' => $fechaCobro,
                              'aut_cobro' => 0,
                              'usuario_id' => Auth::user()->id,
            		]);

                }

                $msg = '$ '.$abonoNac->monto.' fueron abonados a Cliente Nº '.$abonoNac->clienteNacional->descripcion.' exitosamente.';
                return redirect()->route('abonosNacional')->with(['status' => $msg]);

        }
}
