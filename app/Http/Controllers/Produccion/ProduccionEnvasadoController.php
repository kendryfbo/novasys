<?php

namespace App\Http\Controllers\Produccion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\Nivel;
use App\Models\Formula;
use App\Models\Producto;
use App\Models\Reproceso;
use App\Models\Bodega\Bodega;
use App\Models\FormulaDetalle;
use App\Models\Config\StatusDocumento;
use App\Models\Produccion\ProdEnvDetalle;
use App\Models\Produccion\ProduccionEnvasado;


class ProduccionEnvasadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $completa = StatusDocumento::completaID();
        $pendiente = StatusDocumento::pendienteID();

        $prodEnvasado = ProduccionEnvasado::with('formula.producto','status')->where('status_id',$pendiente)->get();
        $prodEnvasadoCompleta = ProduccionEnvasado::with('formula.producto','status')->where('status_id',$completa)->get();

        return view('produccion.envasado.index')->with(['prodEnvasado' => $prodEnvasado, 'prodEnvasadoCompleta' => $prodEnvasadoCompleta]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fecha = Carbon::now()->format('Y-m-d');
        $nivelProduccion = Nivel::produccionID();
        $formulas = Formula::getDataForProdEnvasado();

        return view('produccion.envasado.create')->with([
            'formulas' => $formulas,
            'nivel' => $nivelProduccion,
            'fecha' => $fecha,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request,[
            'formulaID' => 'required',
            //'envasadoID' => 'required',
            'cantBatch' => 'required',
            'nivelID' => 'required',
            'fecha_prod' => 'required',
            'fecha_venc' => 'required',
        ]);

        $prodEnvasado = ProduccionEnvasado::register($request);

        $msg = 'Produccion Envasado Nº '.$prodEnvasado->numero. ' Ha sido creada.';

        return redirect()->route('produccionEnvasado')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prodEnvasado = ProduccionEnvasado::remove($id);

        if ($prodEnvasado) {
            $status = 'Produccion Envasado Nº '.$prodEnvasado->numero.' ha sido eliminado.';
        } else {
            $status = 'Produccion Envasado No ha podido ser eliminado.';
        }

        return redirect()->route('produccionEnvasado')->with(['status' => $status]);
    }

    public function createDescProdEnvasado($id) {

        $nivelProd = Nivel::mezcladoID();
		$nivelPremix = Nivel::premixID();

        $pendiente = StatusDocumento::pendienteID();
        $prodEnvasado = ProduccionEnvasado::with('formula.producto','formula.reproceso','detalles.insumo')->find($id);

        if ($prodEnvasado->status_id != $pendiente) {

            $msg = 'ERROR - Produccion Envasado #' . $prodEnvasado->numero . ' ya ha sido procesada.';
            return redirect()->route('produccionEnvasado')->with(['status' => $msg]);
        }

        $bodegaID = Bodega::getBodMezcladoID(); // id de bodega Mezclado;
        $bodega = Bodega::find($bodegaID);
        $disponible = true;
        $prodEnvasado = ProduccionEnvasado::with('formula.reproceso','detalles.insumo')->find($id);
        $prodEnvasado->reprExistencia = Bodega::getExistTotalRP($prodEnvasado->formula->reproceso->id,$bodegaID);

        $prodEnvasado->detalles->map(function($item) use($bodegaID,&$disponible) {

            $existencia = Bodega::getExistTotalMP($item->insumo_id,$bodegaID);
            $item['existencia'] = $existencia;

            if ($existencia < $item->cantidad) {
                $disponible = false;
            }
        });

        $prodEnvasado->disponible = $disponible;
        $cantReproceso = FormulaDetalle::where('formula_id',$prodEnvasado->formula->id)->whereIn('nivel_id',[$nivelProd,$nivelPremix])->sum('cantxbatch');
        $prodEnvasado->cant_rpr = round(($cantReproceso * $prodEnvasado->cant_batch),2);
        return view('produccion.envasado.descount')->with(['prodEnvasado' => $prodEnvasado, 'bodega' => $bodega]);
    }

    public function storeDescProdEnvasado(Request $request) {
        $id = $request->id;
        $bodegaID = Bodega::getBodMezcladoID(); // id de bodega Mezclado;
        $prodEnvasado = ProduccionEnvasado::processEnvasado($id, $bodegaID);

        $msg = 'Produccion Envasado #' . $prodEnvasado->numero . ' ha sido descontada.';
        return redirect()->route('produccionEnvasado')->with(['status' => $msg]);
    }
}
