<?php

namespace App\Http\Controllers\Finanzas;

use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\FacturaNacional;
use App\Models\Finanzas\PagoNacional;
use App\Models\Finanzas\AbonoNacional;
use App\Models\Finanzas\Bancos;
use App\Models\Comercial\NotaCreditoNac;
use App\Models\Config\StatusDocumento;

class PagosNacionalController extends Controller

{

    public function index() {

        $clientes = ClienteNacional::getAllActive();
        return view('finanzas.pagosNac.index')->with(['clientes' => $clientes]);
      }

      public function create(Request $request) {

          $statusCompleta = StatusDocumento::completaID();
          $clienteID = $request->clienteID;
          $fecha_hoy = Carbon::now();
          $cliente = ClienteNacional::find($clienteID);
          //$bancos = Bancos::where('activo', 1)->get();
          $facturas = FacturaNacional::where('cliente_id',$clienteID)->where('cancelada',0)->get();
          $facturaNumero = $facturas->pluck('numero');
          $saldoTotalAbono = AbonoNacional::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->get()->sum('restante');
          $saldoTotalNC = NotaCreditoNac::whereIn('num_fact', $facturaNumero)->where('status_id','!=',$statusCompleta)->limit(1)->get()->sum('restante');;
          $abonos = AbonoNacional::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->limit(1)->get();
          $notasCredito = NotaCreditoNac::whereIn('num_fact', $facturaNumero)->where('status_id','!=',$statusCompleta)->orderBy('fecha')->limit(1)->get();

          return view('finanzas.pagosNac.create')->with([
                        'cliente' => $cliente,
                        'facturas' => $facturas,
                        'saldoTotalAbono' => $saldoTotalAbono,
                        'abonos' => $abonos,
                        //'bancos' => $bancos,
                        'notasCredito' => $notasCredito,
                        'saldoTotalNC' => $saldoTotalNC]);

      }

      public function store(Request $request) {

        //dd($request->all());

        $msg = 'Pago ha sido registrado.';
        $pago = PagoNacional::register($request);
        //$bancos = Bancos::where('activo', 1)->get();
        $statusCompleta = StatusDocumento::completaID();
        $clienteID = $request->clienteID;
        $fecha_hoy = Carbon::now();
        $cliente = ClienteNacional::find($clienteID);
        $facturas = FacturaNacional::where('cliente_id',$clienteID)->where('cancelada',0)->get();
        $facturaNumero = $facturas->pluck('numero');
        $saldoTotalAbono = AbonoNacional::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->get()->sum('restante');
        $saldoTotalNC = NotaCreditoNac::whereIn('num_fact', $facturaNumero)->where('status_id','!=',$statusCompleta)->limit(1)->get()->sum('restante');;
        $abonos = AbonoNacional::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->limit(1)->get();
        $notasCredito = NotaCreditoNac::whereIn('num_fact', $facturaNumero)->where('status_id','!=',$statusCompleta)->orderBy('fecha')->limit(1)->get();

        return view('finanzas.pagosNac.create')->with([
                      'cliente' => $cliente,
                      'facturas' => $facturas,
                      'saldoTotalAbono' => $saldoTotalAbono,
                      'abonos' => $abonos,
                      //'bancos' => $bancos,
                      'notasCredito' => $notasCredito,
                      'saldoTotalNC' => $saldoTotalNC]);
       }


    /**
     *  Historial Pago de Facturas Nacionales por Cliente
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaNacionalController;
     */

     public function historial(Request $request) {
         $busqueda = $request;
         $facturas = [];

         if ($request->all()) {
             //$queryDates = [];
             $queryClientes = [];

            // if ($request->desde) {
            //     $desde = ['fecha_emision', '>=', $request->desde];
            //     array_push($queryDates,$desde);
            // };

            // if ($request->hasta) {
            //     $hasta = ['fecha_emision', '<=', $request->hasta];
            //     array_push($queryDates,$hasta);
            // };

             if ($request->cliente) {
                 $cliente = ['id', '=', $request->cliente];
                 array_push($queryClientes,$cliente);
             };

             $clientes = ClienteNacional::where($queryClientes)->pluck('id');
             //$facturas = FacturaNacional::where('cliente_id',$clientes)->where('cancelada', 1)->where($queryDates)->get();
             $facturas = FacturaNacional::where('cliente_id',$clientes)->where('cancelada', 1)->get();
         }

         $clientes = ClienteNacional::getAllActive();

         return view('finanzas.pagosNac.historial')
                 ->with([
                     'busqueda' => $busqueda,
                     'facturas' => $facturas,
                     'clientes' => $clientes
                 ]);
     }


    /**
     *  Lista de Facturas por Cobrar
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaNacionalController;
     */

    public function porCobrar(Request $request) {
        $busqueda = $request;
        $facturas = [];

        if ($request->all()) {
            $queryDates = [];
            $queryClientes = [];

            if ($request->desde) {
                $desde = ['fecha_emision', '>=', $request->desde];
                array_push($queryDates,$desde);
            };

            if ($request->hasta) {
                $hasta = ['fecha_emision', '<=', $request->hasta];
                array_push($queryDates,$hasta);
            };

            if ($request->cliente) {
                $cliente = ['id', '=', $request->cliente];
                array_push($queryClientes,$cliente);
            };

            $clientes = ClienteNacional::where($queryClientes)->pluck('id');
            $facturas = FacturaNacional::whereIn('cliente_id',$clientes)->where('cancelada', 0)->where($queryDates)->get();
        }

        $clientes = ClienteNacional::getAllActive();

        return view('finanzas.pagosNac.porCobrar')
                ->with([
                    'busqueda' => $busqueda,
                    'facturas' => $facturas,
                    'clientes' => $clientes
                ]);
    }


    /**
     *  Anular Factura Nacional por Cliente
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaNacionalController;
     */

        public function anularPagoNacional() {
        $clientes = ClienteNacional::getAllActive();
        return view('finanzas.pagosNac.anularPagoNacional')->with(['clientes' => $clientes]);


    }


}
