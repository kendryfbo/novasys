<?php

namespace App\Http\Controllers\Bodega;

use DB;
use Illuminate\Http\Request;
use App\Models\Bodega\Pallet;
use App\Models\Bodega\Posicion;
use App\Models\Bodega\PalletDetalle;
use App\Http\Controllers\Controller;

class PosicionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function storeStatus(Request $request)
    {
            $status_id = $request->status_id;
            $posicion_id = $request->posicion_id;

        try {

            if ((!$status_id) || (!$posicion_id)) {

                return response(404);
            }

            $posicion = Posicion::where('id',$posicion_id)->first();

            $posicion->status_id = $status_id;

            $posicion->save();

            return response('Ok',200);


        } catch (Exception $e) {

            dd($e);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bodega\Posicion  $posicion
     * @return \Illuminate\Http\Response
     */
    public function show(Posicion $posicion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bodega\Posicion  $posicion
     * @return \Illuminate\Http\Response
     */
    public function edit(Posicion $posicion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bodega\Posicion  $posicion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Posicion $posicion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bodega\Posicion  $posicion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posicion $posicion)
    {
        //
    }


    /*
     * Get Pallet From posicion
     * *this should be declared in api controller
     */
    public function getPalletFromPosition(Request $request) {

        $pos_id = $request->posicion_id;
        $posicion = Posicion::find($pos_id);

        $pallet = Pallet::getDataForBodega($posicion->pallet_id);

        if (!$pallet) {

            return response('',200);
        }

        try {

            return response($pallet,200);

        } catch (Exception $e) {

            dd($e);
        }

    }
}
