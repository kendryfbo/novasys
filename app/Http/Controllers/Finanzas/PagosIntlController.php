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

        //$pagos = PagoIntl::take(20)->get();
        /* Cargar solo los clientes con facturas pendientes por cancelar*/
        $clientes = ClienteIntl::where('id', '!=', '0')->get();
        //$pagos = PagoIntl::orderBy('id','DESC')->take(50)->get();
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

       return redirect()->route('pagosIntl');
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


         if ($clienteID == '0') {

             $historial = PagoIntl::historialPagosTodos($clienteID);
             $saldo =  0;

             foreach ($historial as $item) {

                 $saldo = $saldo + ($item->cargo - $item->abono);

                 $item->saldo = $saldo;

                }

         }

        if ($clienteID) {

             $historial = PagoIntl::historialPago($clienteID);
             $saldo =  0;

             foreach ($historial as $item) {

                 $saldo = $saldo + ($item->cargo - $item->abono);

                 $item->saldo = $saldo;

                }

         }

         $busqueda = $request;

         $clientes = ClienteIntl::where('id', '!=', '0')->get();

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


        if ($clienteID == '0') {

            $historial = PagoIntl::historialPagosTodos($clienteID);
            $saldo =  0;

            foreach ($historial as $item) {

                $saldo = $saldo + ($item->cargo - $item->abono);

                $item->saldo = $saldo;

               }

        }

        if ($clienteID) {

            $historial = PagoIntl::historialPago($clienteID);
            $saldo =  0;

            foreach ($historial as $item) {

                $saldo = $saldo + ($item->cargo - $item->abono);

                $item->saldo = $saldo;

            }

        }

        $historial = collect($historial);

        $historial->total_cargo = $historial->sum('cargo');
        $historial->total_abono = $historial->sum('abono');
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
            $saldo =  0;

            foreach ($porCobrar as $item) {

                $saldo = $saldo + ($item->cargo - $item->abono);

                $item->saldo = $saldo;

               }

        }

       if ($clienteID) {

            $porCobrar = PagoIntl::facturasPorPagar($clienteID);
            $saldo =  0;

            foreach ($porCobrar as $item) {

                $saldo = $saldo + ($item->cargo - $item->abono);

                $item->saldo = $saldo;

               }

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
        $porCobrar = [];


        if ($clienteID == '0') {

            $porCobrar = PagoIntl::facturasPorPagarTodas($clienteID);
            $saldo =  0;

            foreach ($porCobrar as $item) {

                $saldo = $saldo + ($item->cargo - $item->abono);

                $item->saldo = $saldo;

               }

        }

        if ($clienteID) {

            $porCobrar = PagoIntl::facturasPorPagar($clienteID);
            $saldo =  0;

            foreach ($porCobrar as $item) {

                $saldo = $saldo + ($item->cargo - $item->abono);

                $item->saldo = $saldo;

            }

        }

        $porCobrar = collect($porCobrar);

        $porCobrar->total_cargo = $porCobrar->sum('cargo');
        $porCobrar->total_abono = $porCobrar->sum('abono');
        $porCobrar->total = $porCobrar->total_cargo - $porCobrar->total_abono;

        $clientes = ClienteIntl::getAllActive();

            Excel::create('Facturas por Cobrar', function($excel) use ($porCobrar)
            {
                $excel->sheet('Facturas por Cobrar', function($sheet) use ($porCobrar)
                {
                    $sheet->loadView('documents.excel.reportFactIntlPorCobrar')->with('pagos',$porCobrar);
                });
            })->export('xls');
        }


        public function reportFactIntlPorCobrarExcelByZonas(Request $request) {
            $saldo =  0;
            $clienteID = 67; //Testing
            $porCobrar = PagoIntl::facturasPorPagarExcelReport($clienteID);
            foreach ($porCobrar as $item) {
                    $saldo = $saldo + ($item->cargo - $item->abono);
                    $item->saldo = $saldo;
                }
            $porCobrar = collect($porCobrar);
            $porCobrar->total_cargo = $porCobrar->sum('cargo');
            $porCobrar->total_abono = $porCobrar->sum('abono');
            $porCobrar->total = $porCobrar->total_cargo - $porCobrar->total_abono;

            $clientes = ClienteIntl::getAllActive();

                Excel::create('Facturas por Cobrar', function($excel) use ($porCobrar)
                {
                    $excel->sheet('Facturas por Cobrar', function($sheet) use ($porCobrar)
                    {
                        $sheet->loadView('documents.excel.reportFactIntlPorCobrarByZonas')->with(['pagos' => $porCobrar]);
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
