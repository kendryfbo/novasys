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
use App\Models\TipoFamilia;
use App\Models\Bodega\Bodega;
use App\Models\Bodega\Pallet;
use App\Models\comercial\Pais;
use App\Models\Bodega\Ingreso;
use App\Models\Bodega\Posicion;
use App\Models\Bodega\PalletCond;
use App\Models\Bodega\IngresoTipo;
use App\Models\Bodega\PalletMedida;
use App\Models\Bodega\PalletDetalle;
use App\Models\Bodega\IngresoDetalle;
use App\Models\Bodega\PalletCondTipo;
use App\Models\Produccion\TerminoProceso;

class PalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pallets = Pallet::with('medida')->where('almacenado',0)->get();

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
        $numero = $this->palletNum();
        $barCode = $this->barCode($numero);
        $medidas = [];

        return view('bodega.pallet.create')->with(
            ['bodegas' => $bodegas, 'tipos' => $tipos, 'medidas' => $medidas, 'numero' => $numero, 'barCode' => $barCode]);
    }

    // creacion de pallet de Materia Prima
    public function createPalletMP() {

        $tipoMP = TipoFamilia::getMP()->id;
        $insumos = IngresoDetalle::with('insumo','ingreso')->where('tipo_id',$tipoMP)->where('por_procesar','>',0)->get();
        $insumos = $insumos->map(function($insumo){
            $newInsumo = collect([
                'id' => $insumo->id,
                'tipo_id' => $insumo->tipo_id,
                'item_id' => $insumo->item_id,
                'codigo' => $insumo->insumo->codigo,
                'descripcion' => $insumo->insumo->descripcion,
                'unidad_med' => $insumo->insumo->unidad_med,
                'fecha_venc' => $insumo->fecha_venc,
                'ing_tipo_id' => $insumo->ingreso->tipo_id,
                'ing_id' => $insumo->ingreso->id,
                'ing_num' => $insumo->ingreso->numero,
                'ing_id' => $insumo->ingreso->id,
                'por_procesar' => $insumo->por_procesar
            ]);

            return $newInsumo;
        });

        $medidas = PalletMedida::getAllActive();
        $numero = $this->palletNum();
        $barCode = $this->barCode($numero);
        $fecha = Carbon::now()->format('Y-m-d');

        return view('bodega.pallet.createPalletMP')->with(['medidas' => $medidas,
            'numero' => $numero, 'barCode' => $barCode, 'insumos' => $insumos, 'fecha' => $fecha
        ]);
    }
    // creacion de pallet de Producto Terminado
    public function createPalletPT() {

        $tipo = TipoFamilia::productoTerminado()->id;
        $productos = IngresoDetalle::getProdIngrPendPorAlmacenar();
        $medidas = PalletMedida::getAllActive();
        $numero = $this->palletNum();
        $barCode = $this->barCode($numero);
        return view('bodega.pallet.createPalletPT')->with(['medidas' => $medidas,
            'numero' => $numero, 'barCode' => $barCode, 'productos' => $productos
        ]);
    }

    // Creacion de pallet Producto Terminado Produccion
    public function createPalletProduccion() {

        $medidas = PalletMedida::getAllActive();
        $palletCondTipos = PalletCondTipo::getAllActive();
        $tipoIngreso = IngresoTipo::termProcID();
        //Prueba
        $opciones = Pais::select('id','nombre as descripcion')->get();

        $tipoPT = TipoFamilia::productoTerminado()->id;
        $productos = IngresoDetalle::with('producto','ingreso')->where('tipo_id',$tipoPT)->where('por_procesar','>',0)->get();

        $numero = Carbon::now()->format('YmdHis');
        $barCode = DNS1D::getBarcodeHTML($numero, "C128",1.85,30,"black",true);

        return view('bodega.pallet.createFromProduccion')->with(
            ['medidas' => $medidas,
             'condiciones' => $palletCondTipos,
             'tipoIngreso' => $tipoIngreso,
             'productos' => $productos,
             'opciones' => $opciones,
             'numero' => $numero,
             'barCode' => $barCode
            ]);
    }

    public function createPalletManual() {

        $tipoIngreso = '';
        $tipoProducto = TipoFamilia::getAllActive();
        $medidas = [];
        $numero = $this->palletNum();
        $barCode = $this->barCode($numero);

        return view('bodega.pallet.createPalletManual')->with([
            'numero' => $numero,
            'barCode' => $barCode,
            'tipoIngreso' => $tipoIngreso,
            'tipoProducto' => $tipoProducto,
            'medidas' => $medidas,
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
        dd($request->all());
    }

    public function storePalletProduccion(Request $request) {

        $this->validate($request,[
            'numero' =>'required',
            'medida' => 'required',
            'items' => 'required'
        ]);

        $pallet = Pallet::storeFromProduccion($request);

        return redirect()->route('verPalletProduccion',['id' => $pallet->id]);
    }

    public function storePalletMP(Request $request) {

        $this->validate($request,[
            'numero' =>'required',
            'medida' => 'required',
            'items' => 'required',
            'fecha' => 'required'
        ]);

        $pallet = Pallet::storePalletMP($request);

        return redirect()->route('verPalletProduccion',['id' => $pallet->id]);
    }
    public function storePalletPT(Request $request) {

        $this->validate($request,[
            'numero' =>'required',
            'medida' => 'required',
            'items' => 'required'
        ]);

        $pallet = Pallet::storePalletMP($request);

        return redirect()->route('verPalletProduccion',['id' => $pallet->id]);
    }

    public function storePalletManual() {

        dd('StorePalletManual');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bodega\Pallet  $pallet
     * @return \Illuminate\Http\Response
     */
    public function show(Pallet $pallet)
    {
        $pallet->load('detalles','medida');
        $barCode = $this->barCode($pallet->numero);

        return view('bodega.pallet.showFromProduccion')->with(['pallet' => $pallet, 'barCode' => $barCode]);

    }

    public function showPalletProduccion(Pallet $pallet)
    {

        $pallet->load('detalles','medida');
        $barCode = $this->barCode($pallet->numero);

        return view('bodega.pallet.showFromProduccion')->with(['pallet' => $pallet, 'barCode' => $barCode]);
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

    public function pdfPalletProd(Pallet $pallet) {

        $pallet = Pallet::getDataForBodega($pallet->id);
        //dd($pallet);
        //$pallet->load('detalles.producto','detalles.produccion');

        $barCode = DNS1D::getBarcodeHTML($pallet->numero, "C128",1,40,"black",true);

        //$pallet->barCode = $barCode;

        $pdf = PDF::loadView('documents.pdf.bodega.labelPalletProd',compact('barCode','pallet'))->setPaper('a5', 'portrait');


        return $pdf->stream();
    }

    public function position(Request $request) {

        //return response($request->all(),200);
        $bodega = $request->bodega;
        $id = $request->id;
        $pallet = Pallet::with('detalles')->find($id);
        $posicion = Posicion::findPositionForPallet($bodega,$id);

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

    public function apiData(Request $request) {

        $pallet = Pallet::where('numero',$request->numero)->first();

        if(!$pallet) {

            return response ('',200);
        }
        $pallet = pallet::getDataForBodega($pallet->id);

        return response($pallet,200);
    }
}
