<?php

namespace App\Http\Controllers\Finanzas;

use Carbon\Carbon;
use Auth;
use Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finanzas\PagoIntl;
use App\Models\Finanzas\AbonoIntl;
use App\Models\Comercial\ClienteIntl;
use App\Models\Comercial\FacturaIntl;
use App\Models\Comercial\NotaCreditoIntl;
use App\Models\Config\StatusDocumento;


class PagosIntlController extends Controller
{
    public function index() {

        /* Cargar solo los clientes con facturas pendientes por cancelar*/
        $clientes = ClienteIntl::where('id', '!=', '0')->get();
        $pagos = PagoIntl::orderBy('id','DESC')->where('numero', 'NOT LIKE', 'Cargo Inicial')->take(50)->get();

        return view('finanzas.pagosIntl.index')->with(['clientes' => $clientes, 'pagos' => $pagos]);
      }

    public function create(Request $request) {

        $statusCompleta = StatusDocumento::completaID();
        $clienteID = $request->clienteID;
        $cliente = ClienteIntl::find($clienteID);
        //$abonos = AbonosIntl::where('cliente_id', $clienteID)->where('status_id',$statusPendiente)->get();

        $facturas = FacturaIntl::where('cliente_id',$clienteID)->where('cancelada',0)->orderBy('fecha_emision')->get();
        $facturaNumero = $facturas->pluck('numero');
        $saldoTotalFacturas = FacturaIntl::where('cliente_id',$clienteID)->where('cancelada',0)->orderBy('fecha_emision')->get()->sum('deuda');
        $saldoTotalAbono = AbonoIntl::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->get()->sum('restante');
        $saldoTotalNC = NotaCreditoIntl::whereIn('num_fact', $facturaNumero)->where('status_id','!=',$statusCompleta)->get()->sum('restante');
        $abonos = AbonoIntl::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->get();
        $notasCredito = NotaCreditoIntl::whereIn('num_fact', $facturaNumero)->where('status_id','!=',$statusCompleta)->orderBy('fecha')->get();

        return view('finanzas.pagosIntl.create')->with([
                      'cliente' => $cliente,
                      'facturas' => $facturas,
                      'saldoTotalAbono' => $saldoTotalAbono,
                      'abonos' => $abonos,
                      'notasCredito' => $notasCredito,
                      'saldoTotalNC' => $saldoTotalNC,
                      'saldoTotalFacturas' => $saldoTotalFacturas]);

                  }



    public function store(Request $request) {

      //dd($request->all());

      $pago = PagoIntl::register($request);
      $clienteID = $request->clienteID;

      return redirect()->route('crearPagoFactIntl',['clienteID' => $clienteID]);
     }

     public function destroy(Request $request) {

       $pagoID = $request->pagoID;

       PagoIntl::unRegister($pagoID);

       return redirect()->route('anulaPagoIntl');
     }

    /**
     *  Historial Pago de Facturas Internacionales x Cliente
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

     public function historial(Request $request) {

         $clienteID = $request->cliente;
         $historial = [];

        if ($clienteID) {
             $historial = PagoIntl::historialPago($clienteID);

         }
         $busqueda = $request;
         $clientes = ClienteIntl::where('id', '!=', '0')->get();
         //dd($historial);

        return view('finanzas.pagosIntl.historial')
                 ->with([
                    'busqueda' => $busqueda,
                    'clientes' => $clientes,
                    'clienteID' => $clienteID,
                    'pagos' => $historial
                 ]);
     }

     public function reportHistorialExcel(Request $request) {

         $clienteID = $request->cliente;
         $historial = [];

         if ($clienteID) {

             $historial = PagoIntl::historialPago($clienteID);
             //dd($historial);
         }

         $historial = collect($historial);
         $historial->total_cargo = $historial->sum('total');
         $historial->total_abono = $historial->total_cargo - $historial->sum('deuda');
         $historial->total = $historial->total_cargo - $historial->total_abono;

         $clientes = ClienteIntl::getAllActive();

             Excel::create('Historial Fact. Intl Pagadas', function($excel) use ($historial)
             {
                 $excel->sheet('Historial Fact. Intl Pagadas', function($sheet) use ($historial)
                 {
                     $sheet->loadView('documents.excel.reportHistorialPagosIntl')->with('pagos', $historial);
                 });
             })->export('xls');
         }
    /**
     *  Lista de Facturas por Cobrar
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

    public function porCobrar(Request $request) {

        $clienteID = $request->cliente;
        $porCobrar = [];


        if ($clienteID == '0') {

            $porCobrar = PagoIntl::facturasPorPagarTodas($clienteID);

        }
       if ($clienteID) {

            $porCobrar = PagoIntl::facturasPorPagar($clienteID);

        }

        $busqueda = $request;
        $clientes = ClienteIntl::getAllActive();

        return view('finanzas.pagosIntl.porCobrar')
                ->with([
                   'busqueda' => $busqueda,
                   'clientes' => $clientes,
                   'clienteID' => $clienteID,
                   'pagos' => $porCobrar
                ]);
       }

    public function reportFactIntlPorCobrarExcel(Request $request) {
        $clienteID = $request->cliente;
        $factPorCobrar = [];

        if ($clienteID == '0') {

            $factPorCobrar = PagoIntl::facturasPorPagarTodas($clienteID);

        }

        if ($clienteID) {

            $factPorCobrar = PagoIntl::facturasPorPagar($clienteID);

        }

        $factPorCobrar = collect($factPorCobrar);
        $factPorCobrar->total_cargo = $factPorCobrar->sum('total');
        $factPorCobrar->total_abono = $factPorCobrar->total_cargo - $factPorCobrar->sum('deuda');
        $factPorCobrar->total = $factPorCobrar->total_cargo - $factPorCobrar->total_abono;

            Excel::create('Facturas por Cobrar', function($excel) use ($factPorCobrar)
            {
                $excel->sheet('Facturas por Cobrar', function($sheet) use ($factPorCobrar)
                {
                    $sheet->loadView('documents.excel.reportFactIntlPorCobrar')->with('pagos',$factPorCobrar);
                });
            })->export('xls');
        }


        public function reportFactIntlPorCobrarExcelByZonas(Request $request) {

             $factPorCobrar = PagoIntl::cuentasCorriente();

             $deudasVencidas = PagoIntl::deudasVencidas();
             $deudasVencidasTotal = PagoIntl::deudasVencidasTotal();

             $totalesPorZona = PagoIntl::totalesFacturaIntlPorZona();

             foreach ($factPorCobrar as $clientes) {
                  //dd($clientes);
                  foreach ($clientes->facturasIntlsPagadas as $facturas) {


                       $fechaEmision = Carbon::parse($facturas->fecha_venc);
                       $fechaExpiracion = Carbon::now();
                       $facturas->diasDiferencia = $fechaExpiracion->diffInDays($fechaEmision);
                       $facturas->zonaCliente = $facturas->clienteIntl->zona;
                       $facturas->cliente = $facturas->clienteIntl->descripcion;
                       $clientes->total_cargo = $clientes->facturasIntlsPagadas->sum('total');

                       $totalCargo = $clientes->total_cargo;
                       $totalDeudaFactPagadas = $clientes->facturasIntlsPagadas->sum('deuda');
                       $anticipoRestante = $clientes->anticipos->sum('restante');
                       $notaCreditoDisponible = $clientes->notaCredito->sum('restante');

                       $clientes->total_abono = $totalCargo - $totalDeudaFactPagadas + $anticipoRestante + $notaCreditoDisponible;

                       $clientes->total_cliente = $clientes->total_cargo - $clientes->total_abono;
                }

               }
               /* Futura implementacion de deudas vencidas
                   foreach ($deudasVencidas as &$deudaVencida) {

                   }
              */

              Excel::create('Por Cobrar', function($excel) use ($factPorCobrar,$deudasVencidas,$totalesPorZona, $deudasVencidasTotal)
                {
                    //sheet 1
                    $excel->sheet('', function($sheet) use ($factPorCobrar,$totalesPorZona)
                    {
                        $sheet->loadView('documents.excel.reportCuentaCorrienteByZonas')->with(['factPorCobrar' => $factPorCobrar,
                                                                                                'totalesPorZona' => $totalesPorZona]);
                    });
                    //sheet 2
                    $excel->sheet('', function($sheet) use ($deudasVencidas)
                    {
                        $sheet->loadView('documents.excel.reportFactIntlPorCobrarEstrucClientes')->with(['pagos' => $deudasVencidas]);
                    });
                    //sheet 3
                    $excel->sheet('', function($sheet) use ($factPorCobrar)
                    {
                        $sheet->loadView('documents.excel.reportFactIntlVencidasPorCobrar')->with(['factPorCobrar' => $factPorCobrar,
                                                                                                    ]);
                    });
                    //sheet 4
                    $excel->sheet('', function($sheet) use ($deudasVencidas, $deudasVencidasTotal)
                    {
                        $sheet->loadView('documents.excel.reportFactIntlDeudaVencida')->with(['deudasVencidas' => $deudasVencidas,
                                                                                                'deudasVencidasTotal' => $deudasVencidasTotal]);
                    });
                })->export('xls');
            }


    /**
     *  Anular Factura Internacional por Cliente
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

        public function anularPagoIntl(Request $request) {
            $busqueda = $request;
            $pagos = [];

           if ($request->all()) {
                $queryClientes = [];

               if ($request->cliente) {
                    $cliente = ['id', '=', $request->cliente];
                    array_push($queryClientes,$cliente);
               };

                $clientes = ClienteIntl::where($queryClientes)->pluck('id');
                $facturas = FacturaIntl::where('cliente_id',$clientes)->pluck('id');
                $pagos = PagoIntl::whereIn('factura_id',$facturas)->orderBy('factura_id')->orderBy('fecha_pago')->get();

           }

            $clientes = ClienteIntl::where('id', '!=', '0')->get();

            return view('finanzas.pagosIntl.anularPagoIntl')
                    ->with([
                       'busqueda' => $busqueda,
                       'clientes' => $clientes,
                       'pagos' => $pagos
                    ]);
        }

}
