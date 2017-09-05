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
            'direccion' => 'required'
        ]);

        $activo = !empty($request->activo);

        SucursalIntl::create([
            'cliente_id' => $request->cliente,
            'descripcion' => $request->descripcion,
            'direccion' => $request->direccion,
            'activo' => $activo
        ]);

        return response('success',201);

    } catch (Exception $e) {

        return response($e,400);
    }
  }

  public function update(Request $request, ClienteIntl $cliente) {

    try {

        $this->validate($request, [
            'id' => 'required',
            'cliente' => 'required',
            'descripcion' => 'required',
            'direccion' => 'required'
        ]);

        $activo = !empty($request->activo);

        $sucursal = SucursalIntl::find($request->id)->first();

        $sucursal->descripcion = $request->descripcion;
        $sucursal->direccion = $request->direccion;
        $sucursal->activo = $activo;

        $sucursal->save();

        return response('success',201);

    } catch (Exception $e) {

        return response($e,400);
    }
  }

  public function destroy($id) {

    if ($id) {

        try {

            SucursalIntl::destroy($id);

            return response('success',201);

        } catch (Exception $e) {

            return response($e,400);
        }

    }
  }
}
