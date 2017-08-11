<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\SucursalIntl;
use App\Models\Comercial\ClienteIntl;

class SucursalIntlController extends Controller
{

  public function show(ClienteIntl $cliente) {

    try {

      $sucursales = SucursalIntl::where('cliente_id', $cliente->id)->get();

      return ($sucursales);

    } catch (Exception $e) {


    }
  }

  public function store(Request $request, ClienteIntl $cliente) {

    try {

      $this->validate($request, [
        'cliente' => 'required',
        'descripcion' => 'required',
        'pais' => 'required',
        'direccion' => 'required'
      ]);

      $activo = !empty($request->activo);

      SucursalIntl::create([
        'cliente_id' => $request->cliente,
        'descripcion' => $request->descripcion,
        'direccion' => $request->direccion,
        'pais' => $request->pais,
        'activo' => $activo
      ]);
      
      return (dd('YES'));

    } catch (Exception $e) {


    }
  }
}
