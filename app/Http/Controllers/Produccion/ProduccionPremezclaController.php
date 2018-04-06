<?php

namespace App\Http\Controllers\Produccion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Nivel;
use App\Models\Formula;
use App\Models\Premezcla;
use App\Models\Producto;
use App\Models\Bodega\Bodega;
use App\Models\FormulaDetalle;
use App\Models\Produccion\ProdPremDetalle;
use App\Models\Produccion\ProduccionPremezcla;

class ProduccionPremezclaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodPremezcla = ProduccionPremezcla::with('premezcla')->get();


        return view('produccion.premezcla.index')->with(['prodPremezcla' => $prodPremezcla]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nivelPremix = Nivel::premixID();
        $formulas = Formula::with('producto','premezcla')->where('autorizado',1)->get();
        $formulas->load(['detalle' => function ($query) use ($nivelPremix){
            $query->where('nivel_id',$nivelPremix);
        },'detalle.insumo']);
        $bodegas = Bodega::getAllActive();

        return view('produccion.premezcla.create')->with([
            'formulas' => $formulas,
            'bodegas' => $bodegas
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
            'premezclaID' => 'required',
            'cantBatch' => 'required',
        ]);

        $prodPremezcla = ProduccionPremezcla::register($request);

        $msg = 'Produccion Premezcla Nº'.$prodPremezcla->numero. ' Ha sido creada.';

        return redirect()->route('produccionPremezcla')->with(['status' => $msg]);

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
        //
    }

    public function createDescProdPremezcla($id) {

        $bodega = null;
        $disponible = true;
        $prodPremezcla = ProduccionPremezcla::with('detalles.insumo')->find($id);

        $prodPremezcla->detalles->map(function($item) use($bodega,&$disponible) {

            $existencia = Bodega::getExistTotalMP($item->insumo_id,$bodega);
            $item['existencia'] = $existencia;

            if ($existencia < $item->cantidad) {
                $disponible = false;
            }
        });

        $prodPremezcla->disponible = $disponible;

        return view('produccion.premezcla.descount')->with(['prodPremezcla' => $prodPremezcla]);
    }
    public function storeDescProdPremezcla() {

    }

}
