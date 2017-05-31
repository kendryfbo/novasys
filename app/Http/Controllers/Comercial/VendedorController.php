<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Comercial\Vendedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendedorController extends Controller
{
    public function index()
    {
        $vendedores = Vendedor::all();

        return view('comercial.vendedores.index')->with(['vendedores' => $vendedores]);
    }

    public function create()
    {
        return view('comercial.vendedores.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'rut' => 'required',
            'nombre' => 'required',
            'iniciales' => 'required'
        ]);

        $activo = !empty($request->activo);

        Vendedor::create([
            'rut' => $request->rut,
            'nombre' => $request->nombre,
            'iniciales' => $request->iniciales,
            'activo' => $activo,
        ]);

        $msg = 'Vendedor: ' . $request->nombre . ' Ha sido Creado.';

        return redirect(route('vendedores.index'))->with(['status' => $msg]);
    }

    public function show(Vendedor $vendedor)
    {
        //
    }

    public function edit(Vendedor $vendedor)
    {

        return view('comercial.vendedores.edit')->with(['vendedor' => $vendedor]);
    }

    public function update(Request $request, Vendedor $vendedor)
    {
        $this->validate($request,[
            'rut' => 'required',
            'nombre' => 'required',
            'iniciales' => 'required'
        ]);

        $activo = !empty($request->activo);

        $vendedor->rut = $request->rut;
        $vendedor->nombre = $request->nombre;
        $vendedor->iniciales = $request->iniciales;
        $vendedor->activo = $activo;

        $vendedor->save();

        $msg = 'Vendedor: ' . $request->nombre . ' Ha sido Modificado.';

        return redirect(route('vendedores.index'))->with(['status' => $msg]);
    }

    public function destroy(Vendedor $vendedor)
    {
        Vendedor::destroy($vendedor->id);

        $msg = 'Vendedor: ' . $vendedor->nombre . ' Ha sido Eliminado.';

        return redirect(route('vendedores.index'))->with(['status' => $msg]);
    }
}
