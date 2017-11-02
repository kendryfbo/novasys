<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DNS1D;
use DNS2D;
use Carbon\Carbon;
use App\Models\Bodega\Bodega;
use App\Models\Bodega\Pallet;
use App\Models\comercial\Pais;
use App\Models\Bodega\PalletCond;
use App\Models\Bodega\PalletMedida;
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
            'fecha_prod' => 'required|date',
            'items' => 'required'
        ]);
        dd($request->ALL());
        //Pallet::createFromProduccion($request);


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

        //Prueba
        $opciones = Pais::select('id','nombre as descripcion')->get();
        $producidos = TerminoProceso::with('producto')->where('almacenado',0)->get();
        $numero = Carbon::now()->format('YmdHis');
        $barCode = DNS1D::getBarcodeHTML($numero, "C128",1.85,30,"black",true);

        return view('bodega.pallet.createFromProduccion')->with(
            ['medidas' => $medidas, 'condiciones' => $palletCondTipos, 'producidos' => $producidos,
             'opciones' => $opciones, 'numero' => $numero, 'barCode' => $barCode]);
    }

    // Creacion de Pallet MateriaPrima
    public function createPalletMateriaPrima() {

    }
}
