<?php

namespace App\Http\Controllers\Finanzas;

use Carbon\Carbon;
use Auth;
use Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\FacturaNacional;
use App\Models\Finanzas\PagoNacional;
use App\Models\Finanzas\AbonoNacional;
use App\Models\Finanzas\Bancos;
use App\Models\Comercial\NotaCreditoNac;
use App\Models\Comercial\NotaDebitoNac;
use App\Models\Finanzas\FormaPago;
use App\Models\Config\StatusDocumento;

class PagosNacionalController extends Controller

{

    public function index() {

        $clientes = ClienteNacional::where('id', '!=', '0')->get();
        $pagos = PagoNacional::orderBy('id','DESC')->take(50)->get();
        return view('finanzas.pagosNac.index')->with(['clientes' => $clientes, 'pagos' => $pagos]);
      }

      public function create(Request $request) {

          $statusCompleta = StatusDocumento::completaID();
          $formasPago = FormaPago::getAllActive();
          $bancos = Bancos::getAllActive();

          $clienteID = $request->clienteID;
          $cliente = ClienteNacional::find($clienteID);

          $facturas = FacturaNacional::where('cliente_id',$clienteID)->where('cancelada',0)->orderBy('fecha_emision')->get();
          $facturaNumero = $facturas->pluck('numero');
          $facturaID = $facturas->pluck('id');
          $saldoTotalFacturas = FacturaNacional::where('cliente_id',$clienteID)->where('cancelada',0)->orderBy('fecha_emision')->get()->sum('deuda');
          $saldoTotalAbono = AbonoNacional::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->get()->sum('restante');
          $saldoTotalNC = NotaCreditoNac::whereIn('num_fact', $facturaNumero)->where('status_id','!=',$statusCompleta)->get()->sum('restante');
          $abonos = AbonoNacional::where('cliente_id', $clienteID)->where('status_id','!=',$statusCompleta)->get();
          $notasCredito = NotaCreditoNac::whereIn('num_fact', $facturaNumero)->where('status_id','!=',$statusCompleta)->orderBy('fecha')->get();
          $notasDebito = NotaDebitoNac::whereIn('factura_id', $facturaID)->where('status_id','!=',$statusCompleta)->orderBy('fecha')->get();
          //dd($notasDebito);

          return view('finanzas.pagosNac.create')->with([
                        'cliente' => $cliente,
                        'facturas' => $facturas,
                        'saldoTotalAbono' => $saldoTotalAbono,
                        'abonos' => $abonos,
                        'notasCredito' => $notasCredito,
                        'notasDebito' => $notasDebito,
                        'saldoTotalNC' => $saldoTotalNC,
                        'formasPago' => $formasPago,
                        'bancos' => $bancos,
                        'saldoTotalFacturas' => $saldoTotalFacturas]);

                    }

    public function store(Request $request) {

        //dd($request->all());
        $pago = PagoNacional::register($request);
        $clienteID = $request->clienteID;

        return redirect()->route('crearPagoFactNacional',['clienteID' => $clienteID]);
    }

    public function destroy(Request $request) {

        $pagoID = $request->pagoID;

        PagoNacional::unRegister($pagoID);

        return redirect()->route('anulaPagoNacional');
    }


    /**
     *  Historial Pago de Facturas Nacionales x Cliente
     *
     * @return \Illuminate\Http\Response
     */

    public function historial(Request $request) {
         $clienteID = $request->cliente;
         $historial = [];
         $totalNotaDebito = [];

         if ($clienteID == 0) {

             $historial = PagoNacional::historialPago($clienteID);
             $totalNotaDebito = PagoNacional::totalNotaDebito($clienteID);

             if ($totalNotaDebito[0]->totalNotaDebito == NULL || $totalNotaDebito[0]->deudaNotaDebito == NULL) {

                 $historial = PagoNacional::historialPago($clienteID);
                 $totalNotaDebito = PagoNacional::totalNotaDebitoNull($clienteID);

             }
          }

        if ($clienteID) {
            $historial = PagoNacional::historialPago($clienteID);
            $totalNotaDebito = PagoNacional::totalNotaDebito($clienteID);


            if ($totalNotaDebito[0]->totalNotaDebito == NULL || $totalNotaDebito[0]->deudaNotaDebito == NULL) {
                $historial = PagoNacional::historialPago($clienteID);
                $totalNotaDebito = PagoNacional::totalNotaDebitoNull($clienteID);

            }
         }

         //Datos de Nota Débito
         $totalND = $totalNotaDebito[0]->totalNotaDebito;
         $totalDeudaND = $totalNotaDebito[0]->deudaNotaDebito;
         //dd($totalND,$totalDeudaND);
         $busqueda = $request;
         $historial = collect($historial);
         $historial->total_cargo = $historial->sum('total') + $totalND;
         $historial->total_abono = $historial->total_cargo - ($historial->sum('deuda') + $totalDeudaND);
         $historial->total = $historial->total_cargo - $historial->total_abono;


         $clientes = ClienteNacional::where('id', '!=', '0')->get();

        return view('finanzas.pagosNac.historial')
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
        $totalNotaDebito = [];

        if ($clienteID == 0) {

            $historial = PagoNacional::historialPago($clienteID);
            $totalNotaDebito = PagoNacional::totalNotaDebito($clienteID);

            if ($totalNotaDebito[0]->totalNotaDebito == NULL || $totalNotaDebito[0]->deudaNotaDebito == NULL) {

                $historial = PagoNacional::historialPago($clienteID);
                $totalNotaDebito = PagoNacional::totalNotaDebitoNull($clienteID);

            }
         }

        if ($clienteID) {
           $historial = PagoNacional::historialPago($clienteID);
           $totalNotaDebito = PagoNacional::totalNotaDebito($clienteID);


           if ($totalNotaDebito[0]->totalNotaDebito == NULL || $totalNotaDebito[0]->deudaNotaDebito == NULL) {
               $historial = PagoNacional::historialPago($clienteID);
               $totalNotaDebito = PagoNacional::totalNotaDebitoNull($clienteID);

           }
        }

        //Datos de Nota Débito
        $totalND = $totalNotaDebito[0]->totalNotaDebito;
        $totalDeudaND = $totalNotaDebito[0]->deudaNotaDebito;
        //dd($totalND,$totalDeudaND);
        $busqueda = $request;
        $historial = collect($historial);
        $historial->total_cargo = $historial->sum('total') + $totalND;
        $historial->total_abono = $historial->total_cargo - ($historial->sum('deuda') + $totalDeudaND);
        $historial->total = $historial->total_cargo - $historial->total_abono;

        $clientes = ClienteNacional::getAllActive();

            Excel::create('Historial Fact. Nac. Pagadas', function($excel) use ($historial)
            {
                $excel->sheet('Historial Fact. Nac. Pagadas', function($sheet) use ($historial)
                {
                    $sheet->loadView('documents.excel.reportHistorialPagosNacional')->with('pagos', $historial);
                });
            })->export('xls');
        }

    /**
     *  Lista de Facturas por Cobrar
     *
     * @return \Illuminate\Http\Response
     */

    public function porCobrar(Request $request) {
        $clienteID = $request->cliente;
        $porCobrar = [];
        $totalNotaDebito = [];

        if ($clienteID == 0) {

            $porCobrar = PagoNacional::facturasPorPagarTodas($clienteID);
            $totalNotaDebito = PagoNacional::totalNotaDebito($clienteID);

            if ($totalNotaDebito[0]->totalNotaDebito == NULL || $totalNotaDebito[0]->deudaNotaDebito == NULL) {

                $porCobrar = PagoNacional::facturasPorPagarTodas($clienteID);
                $totalNotaDebito = PagoNacional::totalNotaDebitoNull($clienteID);
            }
         }

        if ($clienteID) {

           $porCobrar = PagoNacional::facturasPorPagar($clienteID);
           $totalNotaDebito = PagoNacional::totalNotaDebito($clienteID);


           if ($totalNotaDebito[0]->totalNotaDebito == NULL || $totalNotaDebito[0]->deudaNotaDebito == NULL) {
               $porCobrar = PagoNacional::facturasPorPagar($clienteID);
               $totalNotaDebito = PagoNacional::totalNotaDebitoNull($clienteID);

           }
        }
        //Datos de Nota Débito
        $totalND = $totalNotaDebito[0]->totalNotaDebito;
        $totalDeudaND = $totalNotaDebito[0]->deudaNotaDebito;
        //dd($totalND,$totalDeudaND);
        $busqueda = $request;
        $porCobrar = collect($porCobrar);
        $porCobrar->total_cargo = $porCobrar->sum('total') + $totalND;
        $porCobrar->total_abono = $porCobrar->total_cargo - ($porCobrar->sum('deuda') + $totalDeudaND);
        $porCobrar->total = $porCobrar->total_cargo - $porCobrar->total_abono;

        $clientes = ClienteNacional::getAllActive();

        return view('finanzas.pagosNac.porCobrar')
                ->with([
                   'busqueda' => $busqueda,
                   'clientes' => $clientes,
                   'clienteID' => $clienteID,
                   'pagos' => $porCobrar
                ]);
    }



    public function reportFactNacPorCobrarExcel(Request $request) {

            $clienteID = $request->cliente;
            $porCobrar = [];
            $totalNotaDebito = [];

            if ($clienteID == 0) {

                    $porCobrar = PagoNacional::cuentasCorrienteTodas();
                    $totalNotaDebito = PagoNacional::totalNotaDebito($clienteID);

             }

            if ($clienteID) {

               $porCobrar = PagoNacional::cuentasCorriente($clienteID);
               $totalNotaDebito = PagoNacional::totalNotaDebito($clienteID);

               if ($totalNotaDebito[0]->totalNotaDebito == NULL || $totalNotaDebito[0]->deudaNotaDebito == NULL) {
                   $porCobrar = PagoNacional::cuentasCorriente($clienteID);
                   $totalNotaDebito = PagoNacional::totalNotaDebitoNull($clienteID);

               }
            }

            $busqueda = $request;

            //Datos de Nota Débito
            $totalND = $totalNotaDebito[0]->totalNotaDebito;
            $totalDeudaND = $totalNotaDebito[0]->deudaNotaDebito;
            //dd($totalND,$totalDeudaND);

             foreach ($porCobrar as $clientes) {
                foreach ($clientes->facturasNac as &$facturas) {

               $fechaEmision = Carbon::parse($facturas->fecha_venc);
               $fechaExpiracion = Carbon::now();
               $facturas->diasDiferencia = $fechaExpiracion->diffInDays($fechaEmision);
               $facturas->cliente = $facturas->clienteNac->descripcion;

               $clientes->total_cargo = $clientes->facturasNac->sum('total') + $totalND;
               $clientes->total_abono = $clientes->total_cargo - ($clientes->facturasNac->sum('deuda') + $totalDeudaND);
               $clientes->total_cliente = $clientes->total_cargo - $clientes->total_abono;
                }
            }

              Excel::create('Por Cobrar', function($excel) use ($porCobrar)
                {
                    //sheet 1
                    $excel->sheet('', function($sheet) use ($porCobrar)
                    {
                        $sheet->loadView('documents.excel.reportCuentaCorrienteNacional')->with(['factPorCobrar' => $porCobrar]);
                    });
                })->export('xls');
    }




    /**
     *  Anular Factura Internacional por Cliente
     *
     * @return \Illuminate\Http\Response
     */

        public function anularPagoNac(Request $request) {
            $busqueda = $request;
            $pagos = [];

           if ($request->all()) {
                $queryClientes = [];

               if ($request->cliente) {
                    $cliente = ['id', '=', $request->cliente];
                    array_push($queryClientes,$cliente);
               };

                $clientes = ClienteNacional::where($queryClientes)->pluck('id');
                $facturas = FacturaNacional::where('cliente_id',$clientes)->pluck('id');
                $pagos = PagoNacional::whereIn('factura_id',$facturas)->orderBy('factura_id')->orderBy('fecha_pago')->get();

           }

           $clientes = ClienteNacional::where('id', '!=', '0')->get();

            return view('finanzas.pagosNac.anularPagoNac')
                    ->with([
                       'busqueda' => $busqueda,
                       'clientes' => $clientes,
                       'pagos' => $pagos
                    ]);
        }

    }
