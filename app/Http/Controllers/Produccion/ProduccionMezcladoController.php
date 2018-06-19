<?php

namespace App\Http\Controllers\Produccion;

use Carbon\Carbon;
use App\Models\Nivel;
use App\Models\Formula;
use Illuminate\Http\Request;
use App\Models\Bodega\Bodega;
use App\Http\Controllers\Controller;
use App\Models\Config\StatusDocumento;
use App\Models\Produccion\ProduccionMezclado;

class ProduccionMezcladoController extends Controller
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

        $prodMezclado = ProduccionMezclado::with('formula.reproceso','status')->where('status_id',$pendiente)->get();
        $prodMezcladoCompleta = ProduccionMezclado::with('formula.reproceso','status')->where('status_id',$completa)->get();

        return view('produccion.mezclado.index')->with(['prodMezclado' => $prodMezclado, 'prodMezcladoCompleta' => $prodMezcladoCompleta]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fecha = Carbon::now()->format('Y-m-d');
        $nivelProd = Nivel::mezcladoID();
        $formulas = Formula::with('producto','reproceso')->where('autorizado',1)->get();
        $formulas->load(['detalle' => function ($query) use ($nivelProd){
            $query->where('nivel_id',$nivelProd);
        },'detalle.insumo','detalle.nivel']);

        return view('produccion.mezclado.create')->with([
            'formulas' => $formulas,
            'nivel' => $nivelProd,
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
        $this->validate($request,[
            'formulaID' => 'required',
            'cantBatch' => 'required',
            'reprocesoID' => 'required',
            'nivelID' => 'required',
            'fecha_prod' => 'required',
            'fecha_venc' => 'required',
        ]);

        $prodMezclado = ProduccionMezclado::register($request);

        $msg = 'Produccion Mezclado #' . $prodMezclado->numero . ' Ha sido Creada.';

        return redirect()->route('produccionMezclado')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Produccion\ProduccionMezclado  $produccionMezclado
     * @return \Illuminate\Http\Response
     */
    public function show(ProduccionMezclado $produccionMezclado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\Produccion\ProduccionMezclado  $produccionMezclado
     * @return \Illuminate\Http\Response
     */
    public function edit(ProduccionMezclado $produccionMezclado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Produccion\ProduccionMezclado  $produccionMezclado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProduccionMezclado $produccionMezclado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Produccion\ProduccionMezclado  $produccionMezclado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prodMezclado = ProduccionMezclado::remove($id);

        if ($prodMezclado) {
            $status = 'Produccion Mezclado Nº '.$prodMezclado->id.' ha sido eliminado.';
        } else {
            $status = 'Produccion Mezclado No ha podido ser eliminado.';
        }

        return redirect()->route('produccionMezclado')->with(['status' => $status]);
    }

    /*
    *
    *   Creacion de descuento de bodega
    *
    */
    public function createDescProdMezclado($id) {

        $pendiente = StatusDocumento::pendienteID();
        $prodMezclado = ProduccionMezclado::with('detalles.insumo')->find($id);

        if ($prodMezclado->status_id != $pendiente) {

            $msg = 'ERROR - Produccion Mezclado #' . $prodMezclado->numero . ' ya ha sido procesada.';
            return redirect()->route('produccionMezclado')->with(['status' => $msg]);
        }

        $bodegaID = Bodega::getBodMezcladoID(); // id de bodega virtual mezclado;
        $bodega = Bodega::find($bodegaID);
        $disponible = true;
        $prodMezclado = ProduccionMezclado::with('formula.reproceso','formula.premezcla','detalles.insumo')->find($id);
        $prodMezclado->premExistencia = Bodega::getExistTotalPR($prodMezclado->formula->premezcla->id,$bodegaID);
        $prodMezclado->detalles->map(function($item) use($bodegaID,&$disponible) {

            $existencia = Bodega::getExistTotalMP($item->insumo_id,$bodegaID);
            $item['existencia'] = $existencia;

            if ($existencia < $item->cantidad) {
                $disponible = false;
            }
        });

        $prodMezclado->disponible = $disponible;

        return view('produccion.mezclado.descount')->with(['prodMezclado' => $prodMezclado, 'bodega' => $bodega]);
    }

    public function storeDescProdMezclado(Request $request) {

        $bodegaID = $request->bodega; // id de bodega Mezclado;
        $id = $request->prodMezclado;

        $prodMezclado = ProduccionMezclado::processMezclado($id, $bodegaID);

        $msg = 'Produccion Mezclado #' . $prodMezclado->numero . ' ha sido descontada.';
        return redirect()->route('produccionMezclado')->with(['status' => $msg]);
    }
}
