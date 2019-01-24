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
        $clientes = ClienteIntl::getAllActive();
        $pagos = PagoIntl::getAll();
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

        //Desactivar dado a que se permite pago directo
        //if ($saldoTotalAbono <= 0 ) {

        //    $msg = "Cliente no posee Saldo en Abonos";
        //    return redirect()->route('pagosIntl')->with(['status' => $msg]);
        //}

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
      $statusCompleta = StatusDocumento::completaID();
      $clienteID = $request->clienteID;
      $fecha_hoy = Carbon::now();
      $cliente = ClienteIntl::find($clienteID);
      $facturas = FacturaIntl::where('cliente_id',$clienteID)->where('cancelada',0)->orderBy('fecha_emision')->get();
      $facturaNumero = $facturas->pluck('numero');
      $saldoTotalFacturas = FacturaIntl::where('cliente_id',$clienteID)->where('cancelada',0)->orderBy('fecha_emision')->get()->sum('deuda');
      $saldoTotalAbono = AbonoIntl::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->get()->sum('restante');
      $saldoTotalNC = NotaCreditoIntl::whereIn('num_fact', $facturaNumero)->where('status_id','!=',$statusCompleta)->get()->sum('restante');;
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


    /**
     *  Historial de Pago de Facturas Internacionales por Clientes
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

     public function historial(Request $request) {
         $busqueda = $request;
         $pagos = [];

        if ($request->all()) {
             $queryClientes = [];

            if ($request->cliente) {
                 $cliente = ['id', '=', $request->cliente];
                 array_push($queryClientes,$cliente);
            };

             $clientes = ClienteIntl::where($queryClientes)->pluck('id');
             $facturas = FacturaIntl::where('cliente_id',$clientes)->where('cancelada', 1)->pluck('id');
             $pagos = PagoIntl::whereIn('factura_id',$facturas)->orderBy('factura_id')->orderBy('fecha_pago')->get();

        }

         $clientes = ClienteIntl::getAllActive();

         return view('finanzas.pagosIntl.historial')
                 ->with([
                    'busqueda' => $busqueda,
                    'clientes' => $clientes,
                    'pagos' => $pagos
                 ]);
     }



    public function reportHistorialExcel(Request $request) {
        $busqueda = $request;
        $pagos = [];

       if ($request->all()) {
            $queryClientes = [];

           if ($request->cliente) {
                $cliente = ['id', '=', $request->cliente];
                array_push($queryClientes,$cliente);
           };

            $clientes = ClienteIntl::where($queryClientes)->pluck('id');
            $facturas = FacturaIntl::where('cliente_id',$clientes)->where('cancelada', 1)->pluck('id');
            $pagos = PagoIntl::whereIn('factura_id',$facturas)->orderBy('factura_id')->orderBy('fecha_pago')->get();

       }

        $clientes = ClienteIntl::getAllActive();

            Excel::create('Historial Fact. Intl Pagadas', function($excel) use ($pagos)
            {
                $excel->sheet('Historial Fact. Intl Pagadas', function($sheet) use ($pagos)
                {
                    $sheet->loadView('documents.excel.reportHistorialPagosIntl')->with('pagos', $pagos);
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
        $busqueda = $request;
        $pagos = [];

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

            $clientes = ClienteIntl::where($queryClientes)->pluck('id');
            $facturas = FacturaIntl::where('cliente_id',$clientes)->where('cancelada', 0)->where($queryDates)->pluck('id');
            $pagos = PagoIntl::whereIn('factura_id', $facturas)->orderBy('factura_id')->get();

        }

        $clientes = ClienteIntl::getAllActive();

        return view('finanzas.pagosIntl.porCobrar')
                ->with([
                    'busqueda' => $busqueda,
                    'pagos' => $pagos,
                    'clientes' => $clientes
                ]);
    }


    public function reportFactIntlPorCobrarExcel(Request $request) {
        $busqueda = $request;
        $pagos = [];

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

            $clientes = ClienteIntl::where($queryClientes)->pluck('id');
            $facturas = FacturaIntl::where('cliente_id',$clientes)->where('cancelada', 0)->where($queryDates)->pluck('id');
            $pagos = PagoIntl::whereIn('factura_id',$facturas)->orderBy('factura_id')->get();
        }

        $clientes = ClienteIntl::getAllActive();

        Excel::create('Fact x Cobrar', function($excel) use ($pagos)
        {
            $excel->sheet('Fact x Cobrar', function($sheet) use ($pagos)
            {
                $sheet->loadView('documents.excel.reportFactIntlPorCobrar')->with('pagos', $pagos);
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

            $clientes = ClienteIntl::getAllActive();

            return view('finanzas.pagosIntl.anularPagoIntl')
                    ->with([
                       'busqueda' => $busqueda,
                       'clientes' => $clientes,
                       'pagos' => $pagos
                    ]);
        }



    public function destroy()
    {
        //
    }

}
