<?php

namespace App\Http\Controllers\Api;

use App\Models\FormulaDetalle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Log;

class FormulaDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $detalle = FormulaDetalle::all();
            if(!$detalle) {
                return response()->json(['message' => 'Ningun Registro'],404);
            }
            return response()->json($detalle,200);

        } catch (QueryException $e) {
            Log::critical("No se pudo realizar la busqueda de Detalle: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");
            return response($e->getMessage(),500);
        } catch (\Exception $e) {
            Log::critical("No se pudo realizar la busqueda de Detalle: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");
            return response("Error Exception",500);
        }

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
                'formula' => 'required',
                'id' => 'required',
                'descripcion' => 'required',
                'nivel' => 'required',
                'cantxuni' => 'required',
                'cantxcaja' => 'required',
                'cantxbatch' => 'required',
                'batch' => 'required'
            ]);

            FormulaDetalle::create([
                'formula_id' => $request->formula,
                'insumo_id' => $request->id,
                'descripcion' => $request->descripcion,
                'nivel_id' => $request->nivel,
                'cantxuni' => $request->cantxuni,
                'cantxcaja' => $request->cantxcaja,
                'cantxbatch' => $request->cantxbatch,
                'batch' => $request->batch
            ]);

            return response()->json("Agregado",200);

        } catch (QueryException $e) {

            Log::critical("ERROR-DB FormulaDetalleController@store: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("ERROR FormulaDetalleController@store: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response("Error Exception",500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormulaDetalle  $formulaDetalle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $detalle = FormulaDetalle::with('insumo:id,familia_id')->where('id',$id)->get();

            return response()->json($detalle,200);

        } catch (QueryException $e) {

            Log::critical("ERROR-DB FormulaDetalleController@show: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("ERROR FormulaDetalleController@show: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response("Error Exception",500);
        }

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormulaDetalle  $formulaDetalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormulaDetalle $detalle)
    {
        try {

            $this->validate($request, [
                'formula' => 'required',
                'id' => 'required',
                'descripcion' => 'required',
                'nivel' => 'required',
                'cantxuni' => 'required',
                'cantxcaja' => 'required',
                'cantxbatch' => 'required',
                'batch' => 'required'
            ]);

            $detalle->formula_id = $request->formula;
            $detalle->insumo_id = $request->id;
            $detalle->descripcion = $request->descripcion;
            $detalle->nivel_id = $request->nivel;
            $detalle->cantxuni = $request->cantxuni;
            $detalle->cantxcaja = $request->cantxcaja;
            $detalle->cantxbatch = $request->cantxbatch;
            $detalle->batch = $request->batch;

            $detalle->save();

            return response()->json("Actualizado",200);

        } catch (QueryException $e) {

            Log::critical("ERROR-DB FormulaDetalleController@update: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response($e->getMessage(),500);

        } catch (\Exception $e) {

            Log::critical("ERROR FormulaDetalleController@update: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response("Error Exception",500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormulaDetalle  $formulaDetalle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

             FormulaDetalle::destroy($id);

            return response()->json("Eliminado",200);

        } catch (QueryException $e) {

            Log::critical("ERROR-DB FormulaDetalleController@destory: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response("ERROR-DB interno, contacte al Administrador",500);

        } catch (\Exception $e) {

            Log::critical("ERROR FormulaDetalleController@formula: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response("ERROR interno, contacte al Administrador",500);
        }
    }

    public function insert(Request $request)
    {
        $this->validate($request, [
            'formula' => 'required',
            'id' => 'required',
            'descripcion' => 'required',
            'nivel' => 'required',
            'cantxuni' => 'required',
            'cantxcaja' => 'required',
            'cantxbatch' => 'required',
            'batch' => 'required'
        ]);

        $detalle = Formuladetalle::where('formula_id',$request->formula)->where('insumo_id',$request->id)->first();

        if ($detalle)
        {
            self::update($request,$detalle);

        } else {

            self::store($request);
        }

    }

    public function getFormula($id = NULL) {

        try {

            $detalle = FormulaDetalle::with('nivel:id,descripcion')->where('formula_id',$id)->get();

            return response()->json($detalle,200);

        } catch (QueryException $e) {

            Log::critical("ERROR-DB FormulaDetalleController@formula: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response("ERROR-DB interno, contacte al Administrador",500);

        } catch (\Exception $e) {

            Log::critical("ERROR FormulaDetalleController@formula: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response("ERROR interno, contacte al Administrador",500);
        }

    }

    public function import(Request $request) {

        try {

            $this->validate($request, [
                'producto' => 'required',
                'productoImport' => 'required'
            ]);
            
            FormulaDetalle::import($request->producto,$request->productoImport);

            return response()->json('Importado',200);

        } catch (QueryException $e) {

            Log::critical("ERROR-DB FormulaDetalleController@Import: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response("ERROR-DB interno, contacte al Administrador",500);

        } catch (\Exception $e) {

            Log::critical("ERROR FormulaDetalleController@Import: {$e->getCode()},{$e->getLine()} {$e->getMessage()}");

            return response("ERROR interno, contacte al Administrador",500);
        }
    }
}
