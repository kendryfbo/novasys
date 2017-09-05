<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Comercial\Pais;
use App\Models\Comercial\Zona;
use App\Models\Comercial\Idioma;
use App\Models\Comercial\ClienteIntl;
use App\Models\Comercial\SucursalIntl;
use App\Models\Comercial\FormaPagoIntl;

class ClienteIntlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $clientes = ClienteIntl::all();

      return view('comercial.clientesIntl.index')->with(['clientes' => $clientes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $zonas = Zona::getAllActive();
      $paises = Pais::getAllActive();
      $idiomas = Idioma::getAllActive();
      $formasPago = FormaPagoIntl::getAllActive();

      return view('comercial.clientesIntl.create')
              ->with([
                'zonas' => $zonas,
                'paises' => $paises,
                'idiomas' => $idiomas,
                'formasPago' => $formasPago
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
      $this->validate($request, [
        'descripcion' => 'required',
        'direccion' => 'required',
        'pais' => 'required',
        'zona' => 'required',
        'idioma' => 'required',
        'fono' => 'required',
        'giro' => 'required',
        'contacto' => 'required',
        'cargo' => 'required',
        'email' => 'required',
        'formaPago' => 'required',
        'credito' => 'required'
      ]);

      $activo = !empty($request->activo);

      $cliente = ClienteIntl::create([
        'descripcion' => $request->descripcion,
        'direccion' => $request->direccion,
        'pais' => $request->pais,
        'zona' => $request->zona,
        'idioma' => $request->idioma,
        'fono' => $request->fono,
        'giro' => $request->giro,
        'fax' => $request->fax,
        'contacto' => $request->contacto,
        'cargo' => $request->cargo,
        'email' => $request->email,
        'fp_id' => $request->formaPago,
        'credito' => $request->credito,
        'activo' => $activo
      ]);

      SucursalIntl::create([
          'cliente_id' => $cliente->id,
          'descripcion' => 'Casa Matriz',
          'direccion' => $cliente->direccion
      ]);

      $msg = 'Cliente '. $request->descripcion .' Ha sido Creado.';

      return redirect(route('clienteIntl'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\ClienteIntl  $clienteIntl
     * @return \Illuminate\Http\Response
     */
    public function show(ClienteIntl $clienteIntl)
    {
      dd($clienteIntl->getAttributes());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\ClienteIntl  $clienteIntl
     * @return \Illuminate\Http\Response
     */
    public function edit(ClienteIntl $clienteIntl)
    {
      $paises = Pais::getAllActive();
      $formasPago = FormaPagoIntl::getAllActive();
      $clienteIntl->load('sucursales');
      return view('comercial.clientesIntl.edit')->with(['paises' => $paises, 'formasPago' => $formasPago, 'cliente' => $clienteIntl]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\ClienteIntl  $clienteIntl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClienteIntl $clienteIntl)
    {
        $this->validate($request, [
          'descripcion' => 'required',
          'direccion' => 'required',
          'pais' => 'required',
          'zona' => 'required',
          'idioma' => 'required',
          'fono' => 'required',
          'giro' => 'required',
          'contacto' => 'required',
          'cargo' => 'required',
          'email' => 'required',
          'formaPago' => 'required',
          'credito' => 'required'
        ]);

        $activo = !empty($request->activo);

        $clienteIntl->descripcion = $request->descripcion;
        $clienteIntl->direccion = $request->direccion;
        $clienteIntl->pais = $request->pais;
        $clienteIntl->zona = $request->zona;
        $clienteIntl->idioma = $request->idioma;
        $clienteIntl->fono = $request->fono;
        $clienteIntl->giro = $request->giro;
        $clienteIntl->fax = $request->fax;
        $clienteIntl->contacto = $request->contacto;
        $clienteIntl->cargo = $request->cargo;
        $clienteIntl->email = $request->email;
        $clienteIntl->fp_id = $request->formaPago;
        $clienteIntl->credito = $request->credito;
        $clienteIntl->activo = $activo;

        $clienteIntl->save();

        $msg = 'Cliente '. $clienteIntl->descripcion .' Ha sido Modificada.';

        return redirect(route('clienteIntl'))->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\ClienteIntl  $clienteIntl
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClienteIntl $clienteIntl)
    {
        dd('Temporalmente deshabilitado');
    }
}
