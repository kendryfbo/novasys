<?php

namespace App\Http\Controllers\Produccion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\Nivel;
use App\Models\Formula;
use App\Models\Producto;
use App\Models\Premezcla;
use App\Models\Bodega\Bodega;
use App\Models\FormulaDetalle;
use App\Models\Config\StatusDocumento;
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
        $completa = StatusDocumento::completaID();
        $pendiente = StatusDocumento::pendienteID();

        $prodPremezcla = ProduccionPremezcla::with('formula.premezcla','status')->where('status_id',$pendiente)->get();
        $prodPremezclaCompleta = ProduccionPremezcla::with('formula.premezcla','status')->where('status_id',$completa)->get();

        return view('produccion.premezcla.index')->with(['prodPremezcla' => $prodPremezcla, 'prodPremezclaCompleta' => $prodPremezclaCompleta]);
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
        },'detalle.insumo','detalle.nivel']);

        return view('produccion.premezcla.create')->with([
            'formulas' => $formulas,
            'nivel' => $nivelPremix,
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
            'nivelID' => 'required',
            'fecha_prod' => 'required',
            'fecha_venc' => 'required'
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
        $prodPrem = ProduccionPremezcla::remove($id);

        if ($prodPrem) {
            $status = 'Produccion Premezcla Nº '.$prodPrem->id.' ha sido eliminado.';
        } else {
            $status = 'Produccion Premezcla No ha podido ser eliminado.';
        }

        return redirect()->route('produccionPremezcla')->with(['status' => $status]);
    }

    public function createDescProdPremezcla($id) {

        $pendiente = StatusDocumento::pendienteID();
        $prodPremezcla = ProduccionPremezcla::with('detalles.insumo')->find($id);

        if ($prodPremezcla->status_id != $pendiente) {

            $msg = 'ERROR - Produccion Premezcla #' . $prodPremezcla->numero . ' ya ha sido procesada.';
            return redirect()->route('produccionPremezcla')->with(['status' => $msg]);
        }

        $bodegaID = Bodega::getBodPremixID(); // id de bodega premix;
        $bodega = Bodega::find($bodegaID);
        $disponible = true;
        $prodPremezcla = ProduccionPremezcla::with('detalles.insumo')->find($id);

        $prodPremezcla->detalles->map(function($item) use($bodegaID,&$disponible) {

            $existencia = Bodega::getExistTotalMP($item->insumo_id,$bodegaID);
            $item['existencia'] = $existencia;

            if ($existencia < $item->cantidad) {
                $disponible = false;
            }
        });

        $prodPremezcla->disponible = $disponible;

        return view('produccion.premezcla.descount')->with(['prodPremezcla' => $prodPremezcla, 'bodega' => $bodega]);
    }

    public function storeDescProdPremezcla($id) {

        $bodegaID = Bodega::getBodPremixID(); // id de bodega Premix;
        $prodPremezcla = ProduccionPremezcla::processPremix($id, $bodegaID);

        $msg = 'Produccion Premezcla #' . $prodPremezcla->numero . ' ha sido descontada.';
        return redirect()->route('produccionPremezcla')->with(['status' => $msg]);
    }


}
