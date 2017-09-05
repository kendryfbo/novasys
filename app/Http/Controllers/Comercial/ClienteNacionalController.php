<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Models\Comercial\Canal;
use App\Models\Comercial\Region;
use App\Models\Comercial\Comuna;
use App\Models\Comercial\Vendedor;
use App\Models\Comercial\Sucursal;
use App\Models\Comercial\Provincia;
use App\Http\Controllers\Controller;
use App\Models\Comercial\ListaPrecio;
use App\Models\Comercial\FormaPagoNac;
use App\Models\Comercial\ClienteNacional;

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
        $formasPago = FormaPagoNac::getAllActive();
        $listasPrecios = ListaPrecio::getAllActive();
        $canales = Canal::getAllActive();

        return view('comercial.clientesNacionales.create')->with([
            'vendedores' => $vendedores,
            'regiones' => $regiones,
            'formasPago' => $formasPago,
            'listasPrecios' => $listasPrecios,
            'canales' =>$canales
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
            'rut_num' => 'required',
            'contacto' => 'required',
            'cargo' => 'required',
            'email' => 'required',
            'formaPago' => 'required',
            'lista' => 'required',
            'canal' => 'required',
            'region' => 'required',
            'provincia' => 'required',
            'comuna' => 'required',
            'vendedor' => 'required'
        ]);
        $activo = !empty($request->activo);

        $cliente = ClienteNacional::create([
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
            'fp_id' => $request->formaPago,
            'lp_id' => $request->lista,
            'canal_id' => $request->canal,
            'region_id' => $request->region,
            'provincia_id' => $request->provincia,
            'comuna_id' => $request->comuna,
            'vendedor_id' => $request->vendedor,
            'activo' => $activo
        ]);

        Sucursal::create([
            'cliente_id' => $cliente->id,
            'descripcion' => 'Casa Matriz',
            'direccion' => $cliente->direccion
        ]);

        $msg = 'Cliente: ' . $cliente->descripcion . ' Ha sido Creado.';

        return redirect(route('clientesNacionales.index'))->with(['status' => $msg]);

    }

    public function show(ClienteNacional $cliente)
    {
        dd('En Construcción');
    }

    public function edit(ClienteNacional $cliente)
    {
        $regiones = Region::all();
        $provincias = Provincia::all()->where('region_id',$cliente->region_id);
        $comunas = Comuna::all()->where('provincia_id',$cliente->provincia_id);
        $vendedores = Vendedor::getAllActive();
        $formasPago = FormaPagoNac::getAllActive();
        $listasPrecios = ListaPrecio::getAllActive();
        $canales = Canal::getAllActive();

        return view('comercial.clientesNacionales.edit')->with([
            'cliente' => $cliente,
            'regiones' => $regiones,
            'provincias' => $provincias,
            'comunas' => $comunas,
            'vendedores' => $vendedores,
            'formasPago' => $formasPago,
            'listasPrecios' => $listasPrecios,
            'canales' => $canales,
            // 'sucursales' => $sucursales
        ]);
    }

    public function update(Request $request, ClienteNacional $cliente)
    {
        $this->validate($request, [
            'direccion' => 'required',
            'fono' => 'required',
            'giro' => 'required',
            'rut_num' => 'required',
            'contacto' => 'required',
            'cargo' => 'required',
            'email' => 'required',
            'lista' => 'required',
            'canal' => 'required',
            'region' => 'required',
            'provincia' => 'required',
            'comuna' => 'required'
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
        $cliente->lp_id = $request->lista;
        $cliente->canal_id = $request->canal;
        $cliente->region_id = $request->region;
        $cliente->provincia_id = $request->provincia;
        $cliente->comuna_id = $request->comuna;
        $cliente->activo = $activo;

        $cliente->save();

        $msg = 'Cliente: ' . $cliente->descripcion . ' Ha sido Modificado.';

        return redirect(route('clientesNacionales'))->with(['status' => $msg]);

    }

    public function destroy(ClienteNacional $cliente)
    {
        $cliente->delete();

        $msg = 'Cliente: ' . $cliente->descripcion . ' Ha sido Eliminado.';

        return redirect(route('clientesNacionales.index'))->with(['status' => $msg]);
    }
}
