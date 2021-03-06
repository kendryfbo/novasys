<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Comercial\Aduana;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\MedioTransporte;

class AduanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $aduanas = Aduana::all();

      return view('comercial.aduana.index')->with(['aduanas' => $aduanas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $tipos = MedioTransporte::getAllActive();

      return view('comercial.aduana.create')->with(['tipos' => $tipos]);
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
        'direccion' => 'required',
        'ciudad' => 'required',
        'comuna' => 'required',
        'fono' => 'required',
      ]);

      $activo = !empty($request->activo);

      Aduana::create([
        'rut' => $request->rut,
        'descripcion' => $request->descripcion,
        'direccion' => $request->direccion,
        'ciudad' => $request->ciudad,
        'comuna' => $request->comuna,
        'fono' => $request->fono,
        'activo' => $activo
      ]);

      $msg = 'Aduana '. $request->descripcion .' Creada.';

      return redirect(route('aduana'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\Aduana  $aduana
     * @return \Illuminate\Http\Response
     */
    public function show(Aduana $aduana)
    {

        dd($aduana->getAttributes());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\Aduana  $aduana
     * @return \Illuminate\Http\Response
     */
    public function edit(Aduana $aduana)
    {
        $tipos = MedioTransporte::getAllActive();

        return view('comercial.aduana.edit')->with(['aduana' => $aduana, 'tipos' => $tipos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\Aduana  $aduana
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aduana $aduana)
    {
        $this->validate($request,[
          'rut' => 'required',
          'descripcion' => 'required',
          'direccion' => 'required',
          'ciudad' => 'required',
          'comuna' => 'required',
          'fono' => 'required',
        ]);

        $activo = !empty($request->activo);

        $aduana->rut = $request->rut;
        $aduana->descripcion = $request->descripcion;
        $aduana->direccion = $request->direccion;
        $aduana->ciudad = $request->ciudad;
        $aduana->comuna = $request->comuna;
        $aduana->fono = $request->fono;
        $aduana->activo = $activo;

        $aduana->save();

        $msg = 'Aduana '. $request->descripcion .' Modificada.';

        return redirect(route('aduana'))->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\Aduana  $aduana
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aduana $aduana)
    {
      $aduana->delete();

      $msg = 'Aduana '. $aduana->descripcion . ' Ha sido Eliminada.';

      return redirect(route('aduana'))->with(['status' => $msg]);
    }
}
