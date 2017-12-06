<?php

namespace App\Http\Controllers\Api;

use App\Models\Comercial\ListaPrecioDetalle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
class ListaPrecioDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lista = NULL)
    {
        if ($lista) {

            $lista = ListaPrecioDetalle::with('producto.marca')->where('lista_id',$lista)->get();

            return response()->json($lista,200);
        }

        $lista = ListaPrecioDetalle::all();

        return response()->json($lista,200);
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
        $this->validate($request, [
            'lista' => 'required',
            'producto' => 'required',
            'precio' => 'required'
        ]);

        try {

            ListaPrecioDetalle::create([
                'lista_id' => $request->lista,
                'producto_id' => $request->producto,
                'precio' => $request->precio
            ]);

            return response("Creada",200);

        } catch (QueryException $e) {

            Log::critical("DB-ERROR - No se pudo realizar la Creacion de ListaPrecioDetalle: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("APP-ERROR - No se pudo realizar la Creacion de ListaPrecioDetalle: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}, {$e}");

            return response($e->getMEssage(),500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\ListaPrecioDetalle  $listaPrecioDetalle
     * @return \Illuminate\Http\Response
     */
    public function show(ListaPrecioDetalle $detalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\ListaPrecioDetalle  $listaPrecioDetalle
     * @return \Illuminate\Http\Response
     */
    public function edit(ListaPrecioDetalle $detalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\ListaPrecioDetalle  $listaPrecioDetalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListaPrecioDetalle $detalle)
    {
        $this->validate($request, [
            'lista' => 'required',
            'producto' => 'required',
            'precio' => 'required'
        ]);

        //dd('valid update');
        try {


            $detalle->lista_id = $request->lista;
            $detalle->producto_id = $request->producto;
            $detalle->precio = $request->precio;

            $detalle->save();

            return response("Modificada",200);

        } catch (QueryException $e) {

            Log::critical("DB-ERROR - No se pudo realizar la Creacion de ListaPrecioDetalle: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("APP-ERROR - No se pudo realizar la Creacion de ListaPrecioDetalle: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}, {$e}");

            return response($e->getMEssage(),500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\ListaPrecioDetalle  $listaPrecioDetalle
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListaPrecioDetalle $detalle)
    {
        try {

            $detalle->delete();

            return response()->json("Eliminada",200);

        } catch (QueryException $e) {

            Log::critical("DB-ERROR - No se pudo realizar la Eliminacion de ListaPrecioDetalle: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("APP-ERROR - No se pudo realizar la Eliminacion de ListaPrecioDetalle: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMEssage(),500);
        }
    }

    public function insert(Request $request)
    {
        $detalle = ListaPrecioDetalle::where('producto_id',$request->producto)
                                        ->where('lista_id',$request->lista)
                                        ->first();

        if($detalle) {

            self::update($request,$detalle);

        } else {

            self::store($request);
        }
    }
}
