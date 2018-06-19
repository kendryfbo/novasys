<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Config\Perfil;
use App\Models\Config\Acceso;

class PerfilAccesoController extends Controller
{
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfiles = Perfil::all();

        return view('config.perfilAcceso.index')->with(['perfiles' => $perfiles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modulos = Acceso::where('modulo','!=','api')->groupBy('modulo')->get(['modulo']);
        $accesos = Acceso::where('modulo','!=','api')->orderBy('modulo')->get();

        return view('config.perfilAcceso.create')->with(['modulos' => $modulos, 'accesos' => $accesos]);
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
            'nombre' => 'required',
            'descripcion' => 'required',
            'items' => 'required',
        ]);

        $perfil = Perfil::register($request);
        $msg = "Perfil ". $perfil->nombre . " ha sido Creado.";

        return redirect(route('perfilAcceso'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perfil = Perfil::find($id);
        $modulos = Acceso::where('modulo','!=','api')->groupBy('modulo')->get(['modulo']);
        $accesos = collect(Acceso::getAllAccessOfPerfil($id));

        return view('config.perfilAcceso.edit')->with(['perfil' => $perfil,'modulos' => $modulos, 'accesos' => $accesos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'nombre' => 'required',
            'descripcion' => 'required',
            'items' => 'required',
        ]);

        $perfil = Perfil::registerEdit($request,$id);
        $msg = "Perfil ". $perfil->nombre . " ha sido Modificada.";

        return redirect(route('perfilAcceso'))->with(['status' => $msg]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function registerAccess() {

        Acceso::registerAccesos();

        $msg = "Nuevos Accesos han sido importados exitosamente.";

        return redirect(route('perfilAcceso'))->with(['status' => $msg]);
    }
}
