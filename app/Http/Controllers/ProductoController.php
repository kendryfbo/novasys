<?php

namespace App\Http\Controllers;

use Excel;
use App\Models\Marca;
use App\Models\Sabor;
use App\Models\Insumo;
use App\Models\Formato;
use App\Models\Formula;
use App\Models\Producto;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::all();
        return view('desarrollo.productos.index')->with(['productos' => $productos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas = Marca::getAllActive();
        $formatos = Formato::getAllActive();
        $sabores = Sabor::getAllActive();

        return view('desarrollo.productos.create')
                ->with([
                    'marcas' => $marcas,
                    'formatos' => $formatos,
                    'sabores' => $sabores
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
            'codigo' => 'required|unique:productos',
            'descripcion' => 'required',
            'marca' => 'required',
            'formato' => 'required',
            'sabor' => 'required',
            'vida_util' => 'required',
            'peso_bruto' => 'required',
            'peso_neto' => 'required',
            'volumen' => 'required'
        ]);

        $activo = !empty($request->activo);
        Producto::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'marca_id' => $request->marca,
            'formato_id' => $request->formato,
            'sabor_id' => $request->sabor,
            'vida_util' => $request->vida_util,
            'peso_bruto' => $request->peso_bruto,
            'peso_neto' => $request->peso_neto,
            'volumen' => $request->volumen,
            'activo' => $activo
        ]);

        $msg = "Producto: " . $request->descripcion . " ha sido Creado.";

        return redirect(route('productos'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($codigo)
    {
        $producto = Producto::with('formula.detalle.insumo')->where('codigo',$codigo)->first();
        $formula = $producto->formula;

        if ($formula) {

            $dollar = 648.508431; // obtener de api
            $totalPrecio = 0;
            $totalxuni = 0;
            $totalxcaja = 0;
            $totalxbatch = 0;

            foreach ($formula->detalle as &$detalle) {


                $lastPrice = Insumo::getLastPriceOfInsumo($detalle->insumo_id);

                if (!$lastPrice) { // no se ha comprado
                    $lastPrice = 0;
                } else if ($lastPrice[0]->moneda_id == 1) { // moneda en pesos

                    $lastPrice = $lastPrice[0]->precio / $dollar;
                } else {
                    $lastPrice = $lastPrice[0]->precio;
                }
                $precioxuni = $lastPrice * $detalle->cantxuni;
                $precioxcaja = $lastPrice * $detalle->cantxcaja;
                $precioxbatch = $lastPrice * $detalle->cantxbatch;
                $detalle->precio = $lastPrice;
                $detalle->precioxuni = $precioxuni;
                $detalle->precioxcaja = $precioxcaja;
                $detalle->precioxbatch = $precioxbatch;
                $totalPrecio += $detalle->precio;
                $totalxuni += $precioxuni;
                $totalxcaja += $precioxcaja;
                $totalxbatch += $precioxbatch;
            }

            $formula->detalle->totalPrecio = $totalPrecio;
            $formula->detalle->totalxuni = $totalxuni;
            $formula->detalle->totalxcaja = $totalxcaja;
            $formula->detalle->totalxbatch = $totalxbatch;
            $detallesCosto = $formula->detalle;
        } else {
            $detallesCosto = null;
        }

        return view('desarrollo.productos.show')->with(['producto' => $producto, 'detallesCosto' => $detallesCosto]);
        return Excel::create('Reporte Costo Producto', function($excel) use ($formula) {
            $excel->sheet('New sheet', function($sheet) use ($formula) {
                $sheet->loadView('documents.excel.reportCostoFormula')
                        ->with('formula', $formula);
                            })->download('xlsx');
                        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        //dd('DESHABILITADO TEMPORALMENTE');
        $marcas = Marca::getAllActive();
        $formatos = Formato::getAllActive();
        $sabores = Sabor::getAllActive();
        return view('desarrollo.productos.edit')
                ->with(['producto' => $producto,
                        'marcas' => $marcas,
                        'formatos' => $formatos,
                        'sabores' => $sabores]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        //dd('DESHABILITADO TEMPORALMENTE');
        $this->validate($request,[
            'codigo' => 'required',
            'descripcion' => 'required',
            'marca' => 'required',
            'formato' => 'required',
            'sabor' => 'required',
            'vida_util' => 'required',
            'peso_bruto' => 'required',
            'peso_neto' => 'required',
            'volumen' => 'required'
        ]);

        $activo = !empty($request->activo);

        $producto->codigo = $request->codigo;
        $producto->descripcion = $request->descripcion;
        $producto->marca_id = $request->marca;
        $producto->formato_id = $request->formato;
        $producto->sabor_id = $request->sabor;
        $producto->vida_util = $request->vida_util;
        $producto->peso_bruto = $request->peso_bruto;
        $producto->peso_neto = $request->peso_neto;
        $producto->volumen = $request->volumen;
        $producto->activo = $activo;

        $producto->save();

        $msg = "Producto: " . $producto->descripcion . " ha sido Modificado.";

        return redirect(route('productos'))->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        dd('DESHABILITADO TEMPORALMENTE');
        Producto::destroy($producto->id);

        $msg = "Producto: " . $producto->descripcion . " ha sido Eliminado.";

        return redirect(route('productos'))->with(['status' => $msg]);
    }

    public function getProductos() {
        return Producto::all()->orderBy('descripcion');
    }

    public function getFormatoProducto(Request $request) {
        if ($request->id) {
            $producto = Producto::find($request->id);
            return $producto->formato()->find(1);
        }
        return ('error');
    }

    public function downloadExcel($id) {

        $producto = Producto::with('formula.detalle.insumo')->where('id',$id)->first();
        $formula = $producto->formula;

        if ($formula) {

            $dollar = 648.508431;
            $totalPrecio = 0;
            $totalxuni = 0;
            $totalxcaja = 0;
            $totalxbatch = 0;

            foreach ($formula->detalle as &$detalle) {


                $lastPrice = Insumo::getLastPriceOfInsumo($detalle->insumo_id);

                if (!$lastPrice) { // no se ha comprado
                    $lastPrice = 0;
                } else if ($lastPrice[0]->moneda_id == 1) { // moneda en pesos

                    $lastPrice = $lastPrice[0]->precio / $dollar;
                } else {
                    $lastPrice = $lastPrice[0]->precio;
                }
                $precioxuni = $lastPrice * $detalle->cantxuni;
                $precioxcaja = $lastPrice * $detalle->cantxcaja;
                $precioxbatch = $lastPrice * $detalle->cantxbatch;
                $detalle->precio = $lastPrice;
                $detalle->precioxuni = $precioxuni;
                $detalle->precioxcaja = $precioxcaja;
                $detalle->precioxbatch = $precioxbatch;
                $totalPrecio += $detalle->precio;
                $totalxuni += $precioxuni;
                $totalxcaja += $precioxcaja;
                $totalxbatch += $precioxbatch;
            }

            $formula->detalle->totalPrecio = $totalPrecio;
            $formula->detalle->totalxuni = $totalxuni;
            $formula->detalle->totalxcaja = $totalxcaja;
            $formula->detalle->totalxbatch = $totalxbatch;
            $detallesCosto = $formula->detalle;
        } else {
            $detallesCosto = null;
        }

        return Excel::create('Costo Elaboracion '.$producto->descripcion, function($excel) use ($detallesCosto) {
            $excel->sheet('New sheet', function($sheet) use ($detallesCosto) {
                $sheet->loadView('documents.excel.reportCostoFormula')
                        ->with('detallesCosto', $detallesCosto);
                            })->download('xlsx');
                        });
    }
}
