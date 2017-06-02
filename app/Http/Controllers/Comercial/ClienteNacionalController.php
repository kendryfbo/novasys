<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\Vendedor;
use App\Models\Comercial\Region;
use App\Models\Comercial\Provincia;
use App\Models\Comercial\Comuna;
use App\Models\Comercial\Sucursal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClienteNacionalController extends Controller
{
    public function index()
    {
        $clientes = ClienteNacional::with(['region:id,descripcion', 'vendedor:id,nombre'])->get();

        return view('comercial.clientesNacionales.index')->with(['clientes' => $clientes]);
    }

    public function create()
    {
        $vendedores = Vendedor::getAllActive();
        $regiones = Region::all();

        return view('comercial.clientesNacionales.create')->with([
            'vendedores' => $vendedores,
            'regiones' => $regiones
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'rut' => 'required|regex:"^([0-9]+-[0-9K])$"',
            'descripcion' => 'required',
            'direccion' => 'required',
            'fono' => 'required',
            'giro' => 'required',
            'fax' => 'required',
            'rut_num' => 'required',
            'contacto' => 'required',
            'cargo' => 'required',
            'email' => 'required',
            'region' => 'required',
            'provincia' => 'required',
            'comuna' => 'required',
            'vendedor' => 'required'
        ]);
        $activo = !empty($request->activo);

        ClienteNacional::create([
            'rut' => $request->rut,
            'descripcion' => $request->descripcion,
            'direccion' => $request->direccion,
            'fono' => $request->fono,
            'giro' => $request->giro,
            'fax' => $request->fax,
            'rut_num' => $request->rut_num,
            'contacto' => $request->contacto,
            'cargo' => $request->cargo,
            'email' => $request->email,
            'region_id' => $request->region,
            'provincia_id' => $request->provincia,
            'comuna_id' => $request->comuna,
            'vendedor_id' => $request->vendedor,
            'activo' => $activo
        ]);

        $msg = 'Cliente: ' . $request->descripcion . ' Ha sido Creado.';

        return redirect(route('clientesNacionales.index'))->with(['status' => $msg]);

    }

    public function show(ClienteNacional $cliente)
    {
        return $cliente;
    }

    public function edit(ClienteNacional $cliente)
    {
        $regiones = Region::all();
        $provincias = Provincia::all()->where('region_id',$cliente->region_id);
        $comunas = Comuna::all()->where('provincia_id',$cliente->provincia_id);
        $vendedores = Vendedor::all();
        return view('comercial.clientesNacionales.edit')->with([
            'cliente' => $cliente,
            'regiones' => $regiones,
            'provincias' => $provincias,
            'comunas' => $comunas,
            'vendedores' => $vendedores,
            // 'sucursales' => $sucursales
        ]);
    }

    public function update(Request $request, ClienteNacional $cliente)
    {
        $this->validate($request, [
            'direccion' => 'required',
            'fono' => 'required',
            'giro' => 'required',
            'fax' => 'required',
            'rut_num' => 'required',
            'contacto' => 'required',
            'cargo' => 'required',
            'email' => 'required',
            'region_id' => 'required',
            'provincia_id' => 'required',
            'comuna_id' => 'required'
        ]);
        $activo = !empty($request->activo);

        $cliente->direccion = $request->direccion;
        $cliente->fono = $request->fono;
        $cliente->giro = $request->giro;
        $cliente->fax = $request->fax;
        $cliente->rut_num = $request->rut_num;
        $cliente->contacto = $request->contacto;
        $cliente->cargo = $request->cargo;
        $cliente->email = $request->email;
        $cliente->region_id = $request->region;
        $cliente->provincia_id = $request->provincia;
        $cliente->comuna_id = $request->comuna;
        $cliente->activo = $activo;

        $cliente->save();

        $msg = 'Cliente: ' . $cliente->descripcion . ' Ha sido Modificado.';

        return redirect(route('clientesNacionales.index'))->with(['status' => $msg]);

    }

    public function destroy(ClienteNacional $cliente)
    {
        $cliente->delete();

        $msg = 'Cliente: ' . $cliente->descripcion . ' Ha sido Eliminado.';

        return redirect(route('clientesNacionales.index'))->with(['status' => $msg]);
    }
}
