<?php

namespace App\Http\Controllers\Finanzas;

use Carbon\Carbon;
use Auth;
use Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finanzas\ChequeCartera;


class ChequesCarteraController extends Controller
{

    /**
     * Index de Abonos de Clientes Intl
     *
     * @param  \Illuminate\Http\Request  $request
     */

        public function index(Request $request) {

        $chequesCartera = ChequeCartera::where('aut_cobro',0)->get();
        $busqueda = $request;

        return view('finanzas.chequesCartera.index')->with(['chequesCartera' => $chequesCartera, 'busqueda' =>  $busqueda]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ChequeCartera $chequeCartera)
    {
        $busqueda = $request;

        return view('finanzas.chequesCartera.edit')
                ->with(['chequeCartera' => $chequeCartera,'busqueda' =>  $busqueda]);
    }

    /**
     * Update the specified resource in storage.
     *
     *
     ** @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChequeCartera $chequeCartera)
    {
        $this->validate($request, [
            'fecha_real_cobro' => 'required',

        ]);

        $chequeCartera->aut_cobro = 1;
        $chequeCartera->fecha_real_cobro = $request->fecha_real_cobro;
        $chequeCartera->save();
        $msg = "Cheque en Cartera : " . $chequeCartera->id . " ha sido Depositado";
        return redirect('finanzas/chequesCartera')->with(['status' => $msg]);
    }


    public function downloadExcel(Request $request) {

        $fechaVence = Carbon::now();
        $chequesCartera = ChequeCartera::where('aut_cobro',0)->get();
        $chequesDepositados = ChequeCartera::where('aut_cobro',1)->get();


            Excel::create('Rep.Cheques Cartera o Depositado', function($excel) use ($chequesCartera,$chequesDepositados)

            {
                //Sheet 1
                $excel->sheet('', function($sheet) use ($chequesCartera)
                {
                    $sheet->loadView('documents.excel.reportChequesPorDepositar')->with('chequesCartera',$chequesCartera);
                });

                //Sheet 2
                $excel->sheet('', function($sheet) use ($chequesDepositados)
                {
                    $sheet->loadView('documents.excel.reportHistorialChequesDepositados')->with('chequesDepositados',$chequesDepositados);
                });


            })->export('xls');
        }

}
