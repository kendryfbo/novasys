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

        $prodMezclado = ProduccionMezclado::with('premezcla','status')->where('status_id',$pendiente)->get();
        $prodMezcladoCompleta = ProduccionMezclado::with('premezcla','status')->where('status_id',$completa)->get();

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
        $formulas = Formula::with('producto','premezcla')->where('autorizado',1)->get();
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
            'premezclaID' => 'required',
            'nivelID' => 'required',
            'fecha' => 'required',
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
    public function destroy(ProduccionMezclado $produccionMezclado)
    {
        //
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
        $prodPremezcla = ProduccionMezclado::with('detalles.insumo')->find($id);

        $prodPremezcla->detalles->map(function($item) use($bodegaID,&$disponible) {

            $existencia = Bodega::getExistTotalMP($item->insumo_id,$bodegaID);
            $item['existencia'] = $existencia;

            if ($existencia < $item->cantidad) {
                $disponible = false;
            }
        });

        $prodPremezcla->disponible = $disponible;

        return view('produccion.mezclado.descount')->with(['prodPremezcla' => $prodPremezcla, 'bodega' => $bodega]);
    }

    public function storeDescProdMezclado(Request $request) {

        $bodegaID = $request->bodega; // id de bodega premix;
        $id = $request->prodMezclado;

        $prodMezclado = ProduccionMezclado::processMezclado($id, $bodegaID);

        $msg = 'Produccion Mezclado #' . $prodMezclado->numero . ' ha sido descontada.';
        return redirect()->route('produccionMezclado')->with(['status' => $msg]);
    }
}
