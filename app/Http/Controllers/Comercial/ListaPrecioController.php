<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Comercial\ListaPrecio;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListaPrecioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listasPrecios = ListaPrecio::all();

        return view('comercial.listaPrecios.index')->with(['listasPrecios' => $listasPrecios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comercial.listaPrecios.create');
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
            'descripcion' => 'required'
        ]);
        $activo = !empty($request->activo);

        ListaPrecio::create([
            'descripcion' => $request->descripcion,
            'activo' => $activo
        ]);

        $msg = 'Lista de precios: ' . $request->descripcion . ' Ha sido Creado.';

        return redirect(route('listaPrecios.index'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\ListaPrecio  $listaPrecio
     * @return \Illuminate\Http\Response
     */
    public function show(ListaPrecio $listaPrecio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\ListaPrecio  $listaPrecio
     * @return \Illuminate\Http\Response
     */
    public function edit(ListaPrecio $listaPrecio)
    {
        $listaPrecio->load('detalle');
        $productos = Producto::get(['id','codigo','descripcion','activo'])->where('activo',1);
        return view('comercial.listaPrecios.edit')->with([
            'listaPrecio' => $listaPrecio,
            'productos' => $productos
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\ListaPrecio  $listaPrecio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListaPrecio $listaPrecio)
    {
        $this->validate($request, [
            'descripcion' => 'required'
        ]);
        $activo = !empty($request->activo);

        $listaPrecio->descripcion = $request->descripcion;
        $listaPrecio->activo = $activo;
        $listaPrecio->save();

        $msg = 'Lista de precios: ' . $request->descripcion . ' Ha sido Modificada.';

        return redirect(route('listaPrecios.index'))->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\ListaPrecio  $listaPrecio
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListaPrecio $listaPrecio)
    {
        $listaPrecio->delete();

        $msg = 'Lista de precios: ' . $listaPrecio->descripcion . ' Ha sido Eliminada.';

        return redirect(route('listaPrecios.index'))->with(['status' => $msg]);
    }
}
