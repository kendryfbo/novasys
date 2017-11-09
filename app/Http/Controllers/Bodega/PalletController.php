<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PDF;
use DNS1D;
use DNS2D;
use Carbon\Carbon;
use App\Models\Insumo;
use App\Models\Producto;
use App\Models\Bodega\Bodega;
use App\Models\Bodega\Pallet;
use App\Models\comercial\Pais;
use App\Models\Bodega\Posicion;
use App\Models\Bodega\PalletCond;
use App\Models\Bodega\IngresoTipo;
use App\Models\Bodega\PalletMedida;
use App\Models\Bodega\PalletCondTipo;
use App\Models\Produccion\TerminoProceso;

class PalletController extends Controller
{

    /* Constantes */
    const TERMPROC = 2; // ID Tipo de Ingreso Termino de Proceso

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pallets = Pallet::where('almacenado',0)->get();

        return view('bodega.pallet.index')->with(['pallets' => $pallets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bodegas = [];
        $tipos = [];
        $medidas = [];
        $numero = Carbon::now()->format('YmdHis');

        $png = DNS1D::getBarcodeHTML($numero, "C128",1.85,30,"black",true);

        return view('bodega.pallet.create')->with(
            ['bodegas' => $bodegas, 'tipos' => $tipos, 'medidas' => $medidas, 'numero' => $numero, 'png' => $png]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    public function storePalletProduccion(Request $request) {

        $this->validate($request,[
            'numero' =>'required',
            'medida' => 'required',
            'items' => 'required'
        ]);

        $pallet = Pallet::createFromProduccion($request);

        return redirect()->route('etiquetaPalletProduccion',['id' => $pallet->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bodega\Pallet  $pallet
     * @return \Illuminate\Http\Response
     */
    public function show(Pallet $pallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bodega\Pallet  $pallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pallet $pallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bodega\Pallet  $pallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pallet $pallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bodega\Pallet  $pallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pallet $pallet)
    {
        //
    }

    // Creacion de pallet Producto Terminado
    public function createPalletProduccion() {

        $medidas = PalletMedida::getAllActive();
        $palletCondTipos = PalletCondTipo::getAllActive();
        $tipoIngreso = self::TERMPROC;

        //Prueba
        $opciones = Pais::select('id','nombre as descripcion')->get();

        $producidos = TerminoProceso::with('producto')->where('procesado',0)->orWhere('por_procesar','>',0)->get();
        $numero = Carbon::now()->format('YmdHis');
        $barCode = DNS1D::getBarcodeHTML($numero, "C128",1.85,30,"black",true);

        return view('bodega.pallet.createFromProduccion')->with(
            ['medidas' => $medidas, 'condiciones' => $palletCondTipos, 'producidos' => $producidos,
             'tipoIngreso' => $tipoIngreso,'opciones' => $opciones, 'numero' => $numero,
             'barCode' => $barCode]);
    }

    public function pdfPalletProd(Pallet $pallet) {

        $pallet = Pallet::getDataForBodega($pallet->id);

        //$pallet->load('detalles.producto','detalles.produccion');

        $barCode = DNS1D::getBarcodeHTML($pallet->numero, "C128",1,40,"black",true);

        //$pallet->barCode = $barCode;

        $pdf = PDF::loadView('documents.pdf.bodega.labelPalletProd',compact('barCode','pallet'))->setPaper('a5', 'portrait');


        return $pdf->stream();
    }

    public function position($id) {

        $pallet = Pallet::with('detalles')->find($id);
        $posicion = Posicion::findPositionForPallet(1,$id);
        
        if (!$posicion) {

            return response('NO POSITION',200);
        }

        $posicion = Posicion::with('status')->find($posicion->id);

        return response($posicion,200);
        $productos = [];

        foreach ($pallet->detalles as $detalle) {

            $producto = Producto::with('marca.familia.tipo')->find($detalle->item_id);

            array_push($productos,$producto);
        }
        $positions = Posicion::findPositionFor($productos);
    }

    public function createPalletMateriaPrima() {

        $bodegas = Bodega::getAllActive();
        $insumos = Insumo::getAllActive();
        $medidas = PalletMedida::getAllActive();
        $numero = $this->palletNum();
        $barCode = $this->barCode($numero);

        return view('bodega.pallet.createPalletMP')->with([
            'bodegas' => $bodegas, 'insumos' => $insumos, 'medidas' => $medidas,
            'numero' => $numero, 'barCode' => $barCode
        ]);
    }

    /*
     *    PRIVATE FUNCTIONS
     */

    // generate bar code from a number
    private function barCode($numero) {

        $barCode = DNS1D::getBarcodeHTML($numero, "C128",1,40,"black",true);

        return $barCode;
    }
    // generate pallet num (year-month-day-hours-minutes-seconds)
    private function palletNum() {

        return Carbon::now()->format('YmdHis');
    }


    public function test() {

        $pallet = Pallet::with('detalles')->where('id',7)->first();
        dd($pallet->id);
    }

    public function apiData(Request $request) {

        $pallet = Pallet::where('numero',$request->numero)->first();

        if(!$pallet) {

            return response ('',200);
        }
        $pallet = pallet::getDataForBodega($pallet->id);

        return response($pallet,200);
    }
}
