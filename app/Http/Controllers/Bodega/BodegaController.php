<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Bodega\Bodega;
use App\Models\Bodega\Pallet;
use App\Models\Bodega\Posicion;
use App\Models\Bodega\PosCondTipo;
use App\Models\Comercial\NotaVenta;
use App\Models\Bodega\PalletMedida;
use App\Models\Bodega\PalletDetalle;
use App\Models\Bodega\PosicionStatus;

class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bodegas = Bodega::getAllActive();

        return view('bodega.bodega.index')->with(['bodegas' => $bodegas]);
    }

    public function indexConfig()
    {
        $bodegas = Bodega::all();

        return view('bodega.bodega.indexConfig')->with(['bodegas' => $bodegas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $medidas = PalletMedida::getAllActive();

        return view('bodega.bodega.create')->with(['medidas' => $medidas]);
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
            'descripcion' => 'required',
            'bloque' => 'required',
            'columna' => 'required',
            'estante' => 'required',
            'medida' => 'required'
        ]);

        $request->activo = !empty($request->activo);

        Bodega::createBodega($request);

        return redirect()->route('configBodega');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bodega\Bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function show($bodega)
    {

    }

    public function showStock() {

    }

    public function showStockPT($bodega) {

        $productoT = config('globalVars.PT');

        $stocks = Bodega::getStockFromBodega($bodega,$productoT);
        $bodega = Bodega::find($bodega);

        return view('bodega.bodega.stock')->with(['bodega' => $bodega, 'stocks' => $stocks]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bodega\Bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function edit($bodega)
    {
        $bodegaId = $bodega;
        $bloques = Bodega::getPositions($bodegaId);
        $tiposCondicion = PosCondTipo::getAllActive();
        $status = PosicionStatus::getAllActive();
        $medidas = PalletMedida::all(); // no solo las activas ya que pueden existir posiciones con medidas no activas asignadas

        return view('bodega.bodega.show')->with([
            'bodega' => $bodega,
            'bloques' => $bloques,
            'tiposCondicion' => $tiposCondicion,
            'status' => $status,
            'medidas' => $medidas
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bodega\Bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bodega $bodega)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bodega\Bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bodega $bodega)
    {
        //
    }

    public function consult($bodega) {


        $bloques = Bodega::getPositions($bodega);
        $bodega = Bodega::find($bodega);

        return view('bodega.bodega.consult')->with(['bodega' => $bodega, 'bloques' => $bloques]);
    }

    public function entry() {

        $bodegas = Bodega::getAllActive();

        return view('bodega.bodega.ingresoPallet')->with(['bodegas' => $bodegas]);
    }

    public function storePalletInPosition(Request $request) {

        $this->validate($request, [
            'posicion' => 'required',
            'pallet' => 'required'
        ]);
        $pos_id = $request->posicion;
        $pallet_id = $request->pallet;
        $pallet = Pallet::find($pallet_id);
        $pallet->almacenado = 1;
        $pallet->save();
        $posicion = Posicion::find($pos_id);
        $posicion->pallet_id = $pallet_id;
        $posicion->status_id = 3;
        $posicion->save();

        return redirect()->route('bodega');
    }
}
