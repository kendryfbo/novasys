<?php

namespace App\Http\Controllers\Api;

use App\Models\Comercial\Sucursal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cliente = NULL)
    {
        if ($cliente) {

            $sucursales = Sucursal::where('cliente_id',$cliente)->get();
            return response()->json($sucursales,200);
        }

        $sucursales = Sucursal::all();

        return response()->json($sucursales,200);
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
      try {

            $this->validate($request, [
                'cliente' => 'required',
                'descripcion' => 'required',
                'direccion' => 'required',
                'vendedor_id' => 'required'
            ]);
            Sucursal::create([
                'cliente_id' => $request->cliente,
                'descripcion' => $request->descripcion,
                'direccion' => $request->direccion,
                'vendedor_id' => $request->vendedor_id
            ]);

            return response("Creada",200);

        } catch (QueryException $e) {

            Log::critical("DB-ERROR - No se pudo realizar la Creacion de Sucursal: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("APP-ERROR - No se pudo realizar la Creacion de Sucursal: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}, {$e}");

            return response($e->getMEssage(),500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function show(Sucursal $sucursal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function edit(Sucursal $sucursal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sucursal $sucursal)
    {
      try {

            $this->validate($request, [
                'cliente' => 'required',
                'descripcion' => 'required',
                'direccion' => 'required',
                'vendedor_id' => 'required'
            ]);
            $sucursal->cliente_id = $request->cliente;
            $sucursal->descripcion = $request->descripcion;
            $sucursal->direccion = $request->direccion;
            $sucursal->vendedor_id = $request->vendedor_suc;
            $sucursal->save();

            return response()->json("Modificada",200);

        } catch (QueryException $e) {

            Log::critical("DB-ERROR - No se pudo realizar la Modificacion de Sucursal: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("APP-ERROR - No se pudo realizar la Modificacion de Sucursal: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMEssage(),500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sucursal $sucursal)
    {
        try {

            $sucursal->delete();

            return response()->json("Eliminada",200);

        } catch (QueryException $e) {

            Log::critical("DB-ERROR - No se pudo realizar la Eliminacion de Sucursal: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("APP-ERROR - No se pudo realizar la Eliminacion de Sucursal: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMEssage(),500);
        }
    }

    public function insert(Request $request) {

        $sucursal = Sucursal::where('id',$request->id)->first();

        if($sucursal) {

            self::update($request,$sucursal);

        } else {

            self::store($request);
        }
    }
}
