<?php

namespace App\Http\Controllers\Calidad;

use PDF;
use Mail;
use Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Mail\MailNoConformidad;
use App\Models\Calidad\Estado;
use App\Models\Config\Usuario;
use App\Models\Adquisicion\Area;
use App\Models\Config\UsuarioNovaUno;
use App\Models\Calidad\Noconformidad;
use App\Models\Calidad\Noconformidades;


class CalidadController extends Controller
{
    public function main()
    {
    return view('sgcalidad.main');
	}


    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
        $userFrom = Auth::user()->id;
        $estadoEnviada = Estado::enviadaID();
        $noconformidades = Noconformidad::with('para')->where('desde_id', $userFrom)->orWhere('para_id', $userFrom)->orderBy('id','desc')->get();
        return view('sgcalidad.noConformidad.index')->with(['noconformidades' => $noconformidades, 'estadoEnviada' => $estadoEnviada]);
    }


    public function create()
    {
        $sendToUsers = Usuario::getAllActive();
        $areaUsers = Area::getAllActive();
        return view('sgcalidad.noConformidad.create')->with(['sendToUsers' => $sendToUsers,'areaUsers' => $areaUsers]);
    }


    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $noConformidad = Noconformidad::create([
            "numero" =>  Carbon::now()->format('mysi'),  // Consultar Kendry
            "estado_id" => 1,
            "user_id" => Auth::user()->id,
            "titulo" => $request->input('titulo'),
            "area_id" => $request->input('area'),
            "fecha_deteccion" => $request->input('fecha_deteccion'),
            "fecha_implementacion" => Null,
            "fecha_cierre" => Null,
            "analisis_causa" => '',
            "accion_propuesta" => '',
            "seguimiento_accion" => '',
            "persona_detecta" => $request->input('persona_detecta'),
            "npi" => $request->input('npi'),
            "clausula" => $request->input('clausula'),
            "OAI" => $request->input('OAI'),
            "ORC" => $request->input('ORC'),
            "OPR" => $request->input('OPR'),
            "ORE" => $request->input('ORE'),
            "OPO" => $request->input('OPO'),
            "OBS" => $request->input('OBS'),
            "descripcion" => $request->input('descripcion'),
            "solucion_sugerida" => $request->input('solucion_sugerida'),
            "desde_id" => Auth::user()->id,
            "para_id" => $request->input('para_id')
            ]);

            $msg = "No Conformidad N° " . $noConformidad->id . " ha sido Creado.";
            self::sendEmail($noConformidad);
            return redirect()->route('NoConformidades')->with(['status_id' => $msg]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $noconformidad = Noconformidad::where('id', $id)->first();
        if ($noconformidad->estado_id == 3) {

        $msg = 'No Conformidad Nº' . $noconformidad->id . ' no se puede Contestar porque está Solucionado.';
        return redirect()->route('NoConformidades')->with(['status' => $msg]);
        }
        if ($noconformidad->estado_id == 2) {

        $msg = 'No Conformidad Nº' . $noconformidad->id . ' no se puede Contestar porque ya fue Contestada.';
        return redirect()->route('NoConformidades')->with(['status' => $msg]);
        }
        return view('sgcalidad.noConformidad.edit', compact('noconformidad'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Noconformidad $id)
    {
        $this->validate($request, [
            'estado_id' => 'required',
            'fecha_implementacion' => 'required',
            'analisis_causa' => 'required'
        ]);

        $id->estado_id = $request->estado_id;
        $id->fecha_implementacion = $request->fecha_implementacion;
        $id->analisis_causa = $request->analisis_causa;
        $id->accion_propuesta = $request->accion_propuesta;
        $id->save();

        $msg = "No Conformidad N°" . $id->id . " ha sido Contestada";
        return redirect('sgcalidad/NoConformidades')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Calidad\Noconformidad  $noconformidad
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $noconformidad = Noconformidad::where('id', $id)->first();
        return view('sgcalidad.noConformidad.show')->with(['noconformidad' => $noconformidad]);
    }


    public function list_admin(Request $userCheck)
    {
            $user = Usuario::find(14);
            $user_id = $user->id;
            $estadoEnviada = Estado::enviadaID();
            if (Auth::user()->id == $user_id) {
            $noconformidades = Noconformidad::with('para')->orderBy('id','desc')->get();
            return view('sgcalidad.noConformidad.list_admin')->with(['noconformidades' => $noconformidades, 'estadoEnviada' => $estadoEnviada]);
                } else {
            return view('sgcalidad.noConformidad.not_admin');
                }
    }

    public function administra($id)
    {
        $noconformidad = Noconformidad::where('id', $id)->first();
        return view('sgcalidad.noConformidad.admin', compact('noconformidad'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualiza(Request $request, Noconformidad $id)
    {

        $id->estado_id = $request->estadonc;
        $id->fecha_implementacion = $request->fecha_implementacion;
        $id->analisis_causa = $request->analisis_causa;
        $id->accion_propuesta = $request->accion_propuesta;    
        $id->seguimiento_accion = $request->seguimiento_accion;
        $id->fecha_cierre = $request->fecha_cierre;
        $id->save();

        $msg = "No Conformidad N°" . $id->id . " ha sido Administrada";
        return redirect('sgcalidad/NoConformidades/lista_administrador')->with(['status' => $msg]);
    }

    public function downloadPDF($id)
    {
        $noconformidades = Noconformidad::with('area')->where('id', $id)->orderBy('id','desc')->get();
        $pdf = PDF::loadView('documents.pdf.calidad.noconformidadPDF',compact('noconformidades'));
        return $pdf->stream();
    }


    public function sendEmail(NoConformidad $noConformidad)
    {
            Mail::send(new MailNoConformidad($noConformidad));
            return redirect()->back();
    }

    public function downloadExcel()
    {
        $noconformidades = Noconformidad::with('area')->orderBy('id','desc')->get();
        Excel::create('No Conformidades', function($excel) use ($noconformidades)
        {
            $excel->sheet('No Conformidades', function($sheet) use ($noconformidades)
            {
                $sheet->loadView('documents.excel.listadoNoConformidades')->with('noconformidades', $noconformidades);
            });
        })->export('xls');
    }

}
