<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Formato;
use App\Models\Sabor;

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
            'peso_bruto' => 'required',
            'volumen' => 'required'
        ]);

        $activo = !empty($request->activo);
        Producto::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'marca_id' => $request->marca,
            'formato_id' => $request->formato,
            'sabor_id' => $request->sabor,
            'peso_bruto' => $request->peso_bruto,
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
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
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
        $this->validate($request,[
            'codigo' => 'required',
            'descripcion' => 'required',
            'marca' => 'required',
            'formato' => 'required',
            'sabor' => 'required',
            'peso_bruto' => 'required',
            'volumen' => 'required'
        ]);

        $activo = !empty($request->activo);

        $producto->codigo = $request->codigo;
        $producto->descripcion = $request->descripcion;
        $producto->marca_id = $request->marca;
        $producto->formato_id = $request->formato;
        $producto->sabor_id = $request->sabor;
        $producto->peso_bruto = $request->peso_bruto;
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
}
