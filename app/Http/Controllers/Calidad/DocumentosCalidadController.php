<?php

namespace App\Http\Controllers\Calidad;

use PDF;
use App\Http\Controllers\Controller;
use App\Models\Calidad\DocCalidad;
use App\Models\Config\Usuario;
use App\Models\Adquisicion\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class DocumentosCalidadController extends Controller
    {
    public function main(){
    return view('sgcalidad.main');
	}


    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
        $documentosCalidad = DocCalidad::with('area')->orderBy('id','desc')->get();
        return view('sgcalidad.docs_PDF.index')->with(['documentosCalidad' => $documentosCalidad]);
    }


    public function create()
    {
        $user = Usuario::find(14);
        $user_id = $user->id;
        $docs_PDF = DocCalidad::where('id', $user)->first();
        $areaUsers = Area::getAllActive();

        if (Auth::user()->id == $user_id) {
        $noconformidades = DocCalidad::with('area')->orderBy('id','desc')->get();
        return view('sgcalidad.docs_PDF.create')->with(['areaUsers' => $areaUsers]);
            } else {
        return view('sgcalidad.noConformidad.not_admin');
            }
    }


    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'titulo' => 'required',
            'codigo' => 'required',
            'revision' => 'required',
            'area' => 'required',
            'fecha_ult_rev' => 'required',
            'ruta_directorio' => 'required|max:10000|mimes:pdf',
            ]);

        DocCalidad::create([
            'titulo' => $request->titulo,
            'codigo' => $request->codigo,
            'revision' => $request->revision,
            'area_id' => $request->area,
            'user_id' => Auth::user()->id,
            'fecha_ult_rev' => $request->fecha_ult_rev,
            'ruta_directorio' => $request->ruta_directorio->store('calidad_PDF'),
            ]);

        $msg = "Documento: " . $request->codigo . " ha sido Creado.";

        return redirect(route('documentosCalidad'))->with(['status' => $msg]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $user = Usuario::find(14);
        $user_id = $user->id;
        $docs_PDF = DocCalidad::where('id', $id)->first();
        $areaUsers = Area::getAllActive();

        if (Auth::user()->id == $user_id) {
        $noconformidades = DocCalidad::with('area')->orderBy('id','desc')->get();
        return view('sgcalidad.docs_PDF.edit', compact('docs_PDF'))->with(['areaUsers' => $areaUsers]);
            } else {
        return view('sgcalidad.noConformidad.not_admin');
            }
    }


    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, DocCalidad $id)
    {

        $this->validate($request,[
            'titulo' => 'required',
            'codigo' => 'required',
            'revision' => 'required',
        ]);

        $id->titulo = $request->titulo;
        $id->codigo = $request->codigo;
        $id->revision = $request->revision;
        $id->area_id = $request->area;
        $id->fecha_ult_rev = $request->fecha_ult_rev;
        $id->ruta_directorio = $request->ruta_directorio->store('calidad_PDF');
        $id->save();

        $msg = "Documento N°" . $id->id . " ha sido Actualizado en Sistema";
        return redirect('sgcalidad/Documentos')->with(['status' => $msg]);
    }

    public function downloadPDF($id)
    {
            $documento = DocCalidad::find($id);
            return response()->file($documento->ruta_directorio);
    }

}
