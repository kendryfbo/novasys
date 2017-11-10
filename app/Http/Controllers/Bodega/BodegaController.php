<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Models\Bodega\Bodega;
use App\Models\Bodega\Posicion;
use App\Models\Bodega\PosCondTipo;
use App\Http\Controllers\Controller;
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

        return view('bodega.bodega.create');
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
            'estante' => 'required'
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bodega\Bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function edit($bodega)
    {
        $bloques = Posicion::where('bodega_id',$bodega)->orderBy('bloque','asc')->groupBy('bloque')->pluck('bloque');

        foreach ($bloques as $keyBloq => $bloque) {

            $estantes = Posicion::where('bodega_id',$bodega)->where('bloque',$bloque)->orderBy('estante','desc')->groupBy('estante')->pluck('estante');

            foreach ($estantes as $keyEstante => $estante) {

                $posicion = Posicion::with('status')->orderBy('columna','asc')->where('bodega_id',$bodega)->where('bloque',$bloque)->where('estante',$estante)->get();

                $estantes[$keyEstante] = $posicion;
            }
            $bloques[$keyBloq] = $estantes;
        };

        $tiposCondicion = PosCondTipo::getAllActive();
        $status = PosicionStatus::getAllActive();

        return view('bodega.bodega.show')->with(['bloques' => $bloques, 'tiposCondicion' => $tiposCondicion, 'status' => $status]);

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


        $bloques = Posicion::where('bodega_id',$bodega)->orderBy('bloque','asc')->groupBy('bloque')->pluck('bloque');

        foreach ($bloques as $keyBloq => $bloque) {

            $estantes = Posicion::where('bodega_id',$bodega)->where('bloque',$bloque)->orderBy('estante','desc')->groupBy('estante')->pluck('estante');

            foreach ($estantes as $keyEstante => $estante) {

                $posicion = Posicion::with('status')->orderBy('columna','asc')->where('bodega_id',$bodega)->where('bloque',$bloque)->where('estante',$estante)->get();

                $estantes[$keyEstante] = $posicion;
            }
            $bloques[$keyBloq] = $estantes;
        };
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

        $posicion = Posicion::find($pos_id);
        $posicion->pallet_id = $pallet_id;
        $posicion->status_id = 3;
        $posicion->save();

        return redirect()->route('bodega');
    }
}
