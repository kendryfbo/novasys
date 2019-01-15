<?php

namespace App\Http\Controllers\Adquisicion;

use App\Models\Adquisicion\Proveedor;
use App\Models\Adquisicion\FormaPagoProveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Proveedor::all();

        return view('adquisicion.proveedor.index')
            ->with(['proveedores' => $proveedores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formaPago = FormaPagoProveedor::getAllActive();

        return view('adquisicion.proveedor.create')->with(['formasPagos' => $formaPago]);
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
            'rut' => 'required',
            'descripcion' => 'required',
            'abreviacion' => 'required',
            'direccion' => 'required',
            'comuna' => 'required',
            'ciudad' => 'required',
            'fono' => 'required',
            'giro' => 'required',
            'contacto' => 'required',
            'cargo' => 'required',
            'celular' => 'required',
            'email' => 'required',
            'formaPago' => 'required'
        ]);

        $activo = !empty($request->activo);

        Proveedor::create([
            'rut' => $request->rut,
            'descripcion' => $request->descripcion,
            'abreviacion' => $request->abreviacion,
            'direccion' => $request->direccion,
            'comuna' => $request->comuna,
            'ciudad' => $request->ciudad,
            'fono' => $request->fono,
            'giro' => $request->giro,
            'contacto' => $request->contacto,
            'cargo' => $request->cargo,
            'celular' => $request->celular,
            'email' => $request->email,
            'fp_id' => $request->formaPago,
            'activo' => $activo,
        ]);

        $msg = 'Proveedor ' . $request->descripcion . ' ha sido creado.';

        return redirect()->route('proveedores')->with('status', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adquisicion\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adquisicion\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedor)
    {
        $formasPagos = FormaPagoProveedor::getAllActive();

        return view('adquisicion.proveedor.edit')->with(['proveedor' => $proveedor, 'formasPagos' => $formasPagos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adquisicion\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $this->validate($request,[
            'rut' => 'required',
            'descripcion' => 'required',
            'abreviacion' => 'required',
            'direccion' => 'required',
            'comuna' => 'required',
            'ciudad' => 'required',
            'fono' => 'required',
            'giro' => 'required',
            'contacto' => 'required',
            'cargo' => 'required',
            'celular' => 'required',
            'email' => 'required',
            'formaPago' => 'required'
        ]);

        $activo = !empty($request->activo);

        $proveedor->abreviacion = $request->abreviacion;
        $proveedor->direccion = $request->direccion;
        $proveedor->comuna = $request->comuna;
        $proveedor->ciudad = $request->ciudad;
        $proveedor->fono = $request->fono;
        $proveedor->giro = $request->giro;
        $proveedor->contacto = $request->contacto;
        $proveedor->cargo = $request->cargo;
        $proveedor->celular = $request->celular;
        $proveedor->email = $request->email;
        $proveedor->fp_id = $request->formaPago;
        $proveedor->activo = $activo;

        $proveedor->save();

        $msg = 'Proveedor ' . $proveedor->descripcion . ' ha sido actualizado.';

        return redirect()->route('proveedores')->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adquisicion\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        $msg = 'Proveedor ' . $proveedor->descripcion . ' Ha sido eliminado.';

        return redirect()->route('proveedores')->with(['status' => $msg]);
    }
}
