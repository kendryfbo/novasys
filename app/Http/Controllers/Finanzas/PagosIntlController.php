<?php

namespace App\Http\Controllers\Finanzas;

use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\ClienteIntl;
use App\Models\Comercial\FacturaIntl;
use App\Models\Finanzas\PagoIntl;


class PagosIntlController extends Controller
{

    /**
     * Index de Facturas Intl
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

        public function index() {
        $clientes = ClienteIntl::getAllActive();
        return view('finanzas.pagosIntl.index')->with(['clientes' => $clientes]);


    }



    /**
     * Pago de Facturas Intl
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

        public function create() {
        $fecha_hoy = Carbon::now();
        $clientes = ClienteIntl::getAllActive();
        return view('finanzas.pagosIntl.create')->with(['clientes' => $clientes, 'fecha_hoy' => $fecha_hoy]);


    }



    /**
     *  Historial de Pago de Facturas Internacionales por Clientes
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

        public function historial() {
        $clientes = ClienteIntl::getAllActive();
        return view('finanzas.pagosIntl.historial')->with(['clientes' => $clientes]);


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
