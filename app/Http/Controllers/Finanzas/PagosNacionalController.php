<?php

namespace App\Http\Controllers\Finanzas;

use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\FacturaNacional;
use App\Models\Finanzas\PagoFactNacional;


class PagosNacionalController extends Controller
{


    public function index() {

        $pagos = PagoFactNacional::take(20)->get();
        $facturas = FacturaNacional::where('cancelada',0)->get();
        $clientes = ClienteNacional::getAllActive();

        return view('finanzas.pagosNacional.index')->with(['pagos' => $pagos, 'facturas' => $facturas, 'clientes' => $clientes]);
      }

    public function create(Request $request) {

        $clienteID = $request->clienteID;
        $fecha_hoy = Carbon::now();
        $cliente = ClienteNacional::find($clienteID);

        return view('finanzas.pagosNacional.create')->with(['cliente' => $cliente, 'fecha_hoy' => $fecha_hoy]);;
      }




    /**
     *  Historial de Pago de Facturas Internacionales por Clientes
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

        public function historial() {
        $clientes = ClienteNacional::getAllActive();
        return view('finanzas.pagosNacional.historial')->with(['clientes' => $clientes]);


    }


    /**
     *  Lista de Facturas por Cobrar
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
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

            $clientes = ClienteIntl::where($queryClientes)->pluck('id');
            $facturas = FacturaIntl::whereIn('cliente_id',$clientes)->where($queryDates)->get();
        }

        $clientes = ClienteIntl::getAllActive();

        return view('finanzas.pagosIntl.porCobrar')
                ->with([
                    'busqueda' => $busqueda,
                    'facturas' => $facturas,
                    'clientes' => $clientes
                ]);
    }


    /**
     *  Anular Factura Internacional por Cliente
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

        public function anularPagoIntl() {
        $clientes = ClienteIntl::getAllActive();
        return view('finanzas.pagosIntl.anularPagoIntl')->with(['clientes' => $clientes]);


    }


}
