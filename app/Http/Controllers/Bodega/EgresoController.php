<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PDF;
use Carbon\Carbon;
use App\Models\TipoFamilia;
use App\Models\Bodega\Bodega;
use App\Models\Bodega\Egreso;
use App\Models\Bodega\EgresoTipo;
use App\Models\Comercial\Proforma;
use App\Models\Comercial\NotaVenta;
use App\Models\Config\TipoDocumento;
use App\Models\Config\StatusDocumento;

class EgresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statusCompleta = StatusDocumento::completaID();
        $tipos = [
            EgresoTipo::manualID(),
            EgresoTipo::profID(),
            EgresoTipo::nvID(),
            EgresoTipo::trasladoID(),
        ];

        $egresos = Egreso::with('usuario','tipo','status')
                                ->where('status_id','!=',$statusCompleta)
                                ->whereIn('tipo_id',$tipos)
                                ->orderBy('numero','desc')
                                ->take(20)
                                ->get();

        $egresosProcesados = Egreso::with('usuario','tipo','status')
                                        ->where('status_id','=',$statusCompleta)
                                        ->orderBy('numero','desc')
                                        ->take(20)
                                        ->get();

        return view('bodega.egreso.index')->with(['egresos' => $egresos, 'egresosProcesados' => $egresosProcesados]);
    }
    public function indexPendingOrdenEgreso()
    {
        $tipoProforma  = TipoDocumento::proformaID();
        $tipoNotaVenta = TipoDocumento::notaVentaID();

        $proformas = Proforma::getAllAuthorizedNotProcessed();

        $proformas->map(function ($proforma) use($tipoProforma){

            $proforma['tipo_id'] = $tipoProforma;
            $proforma['tipo'] = 'proforma';

            return $proforma;
        });

        $notasVenta = NotaVenta::getAllAuthorizedNotProcessed();

        $notasVenta->map(function ($notaVenta) use($tipoNotaVenta){

            $notaVenta['tipo_id'] = $tipoNotaVenta;
            $notaVenta['tipo'] = 'nota Venta';

            return $notaVenta;
        });

        return view('bodega.egreso.indexOrdenEgreso')->with(['notasVenta' => $notasVenta, 'proformas' => $proformas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function createEgrOrdenEgreso(Request $request)
    {
        $tipoProforma  = TipoDocumento::proformaID();
        $tipoNotaVenta = TipoDocumento::notaVentaID();

        $bodegas = Bodega::getAllActive();
        $documento = [];

        $this->validate($request,[
            'tipo' => 'required',
            'id' => 'required',
        ]);

        if ($tipoProforma == $request->tipo) {

            $documento = Proforma::with('detalles')->where('id',$request->id)->first();
            $documento->tipo_id = $tipoProforma;
            $documento->tipo = 'Proforma';
        }
        else if ($tipoNotaVenta == $request->tipo) {

            $documento = NotaVenta::with('detalles')->where('id',$request->id)->first();
            $documento->tipo_id = $tipoNotaVenta;
            $documento->tipo = 'Nota de Venta';
        }

        return view('bodega.egreso.createEgrOrdenEgreso')->with(['documento' => $documento, 'bodegas' => $bodegas]);
    }

    public function createEgrManualMP(Request $request) {

        $titulo = "Egreso Manual Materia Prima";
        $tipoEgreso = EgresoTipo::manualID();
        $tipoProd = TipoFamilia::getInsumoID();
        $bodegas = Bodega::getAllActive();
        $fecha = Carbon::now()->toDateString();

        return view('bodega.egreso.createEgresoManual')->with([
            'titulo' => $titulo,
            'bodegas' => $bodegas,
            'tipoEgreso' => $tipoEgreso,
            'tipoProd' => $tipoProd,
            'fecha' => $fecha,
        ]);
    }

    public function createEgrManualPT(Request $request) {

        $titulo = "Egreso Manual Producto Terminado";
        $tipoEgreso = EgresoTipo::manualID();
        $tipoProd = TipoFamilia::getProdTermID();
        $bodegas = Bodega::getAllActive();
        $fecha = Carbon::now()->toDateString();

        return view('bodega.egreso.createEgresoManual')->with([
            'titulo' => $titulo,
            'bodegas' => $bodegas,
            'tipoEgreso' => $tipoEgreso,
            'tipoProd' => $tipoProd,
            'fecha' => $fecha,
        ]);
    }
    public function createEgrManualPR(Request $request) {

        $titulo = "Egreso Manual Premezcla";
        $tipoEgreso = EgresoTipo::manualID();
        $tipoProd = TipoFamilia::getPremezclaID();
        $bodegas = Bodega::getAllActive();
        $fecha = Carbon::now()->toDateString();

        return view('bodega.egreso.createEgresoManual')->with([
            'titulo' => $titulo,
            'bodegas' => $bodegas,
            'tipoEgreso' => $tipoEgreso,
            'tipoProd' => $tipoProd,
            'fecha' => $fecha,
        ]);
    }
    public function createEgrManualRP(Request $request) {

        $titulo = "Egreso Manual Reproceso";
        $tipoEgreso = EgresoTipo::manualID();
        $tipoProd = TipoFamilia::getReprocesoID();
        $bodegas = Bodega::getAllActive();
        $fecha = Carbon::now()->toDateString();

        return view('bodega.egreso.createEgresoManual')->with([
            'titulo' => $titulo,
            'bodegas' => $bodegas,
            'tipoEgreso' => $tipoEgreso,
            'tipoProd' => $tipoProd,
            'fecha' => $fecha,
        ]);
    }

    public function createEgrTrasladoMP(Request $request) {

        $tipoEgreso = EgresoTipo::manualID();
        $tipoProd = TipoFamilia::getInsumoID();
        $bodegas = Bodega::getAllActive();
        //$insumos = collect(Bodega::getStockOfMPFromBodega());
        $insumos = collect();
        $fecha = Carbon::now()->toDateString();

        return view('bodega.egreso.createEgresoTraslado')->with([
            'bodegas' => $bodegas,
            'insumos' => $productos,
            'tipoEgreso' => $tipoEgreso,
            'tipoProd' => $tipoProd,
            'fecha' => $fecha,
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
        //
    }

    public function storeEgrOrdenEgreso(Request $request)
    {
        $this->validate($request,[
            'bodega' => 'required',
            'tipo' => 'required',
            'id' => 'required',
        ]);

        $bodega = intval($request->bodega);
        $tipo = intval($request->tipo);
        $id = intval($request->id);
        $user = $request->user()->id;

        $egreso = Egreso::generate($user,$tipo,$id,$bodega);

        return redirect()->route('verEgreso', ['numero' => $egreso->numero]);
    }

    // Guardar Egreso Manual Materia Prima
    public function storeEgrManual(Request $request)
    {

        $this->validate($request,[
            'descripcion' =>'required',
            'tipo_egreso' => 'required',
            'tipo_prod' => 'required',
            'fecha' => 'required|date',
            'items' => 'required',
        ]);

        $egreso = Egreso::register($request);

        return redirect()->route('verEgreso', ['numero' => $egreso->numero]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
        $egreso = Egreso::where('numero',$numero)->first();
        //$ordenEgreso->load('documento');
        $egreso->detalles->load('item');

        if (!$egreso) {

            dd('Orden Egreso no existe...');
        }

        return view('bodega.egreso.show')->with(['egreso' => $egreso]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function downloadPDF($numero) {

        $tipoProforma= EgresoTipo::profID();
        $tipoNotaVenta = EgresoTipo::nvID();
        $egreso = Egreso::where('numero',$numero)->first();
        $egreso->tipo();

        $egreso->load('documento','detalles','tipo');
        if ($egreso->tipo_id == $tipoProforma || $egreso->tipo_id == $tipoNotaVenta) {

        } else {

            $egreso->load('detalles');
        }

        $pdf = PDF::loadView('bodega.egreso.pdf',compact('egreso'));

        return $pdf->stream('Orden Egreso N°'.$egreso->numero.'.pdf');
    }

    // API FUNCTIONS

    public function checkOrdenEgresoExist(Request $request) {

        $tipoProforma  = TipoDocumento::proformaID();
        $tipoNotaVenta = TipoDocumento::notaVentaID();

        $tipoDoc = $request->tipoDoc;
        $docId = $request->docId;
        $bodega = $request->bodega;
        if ($tipoDoc == $tipoProforma) {

            $documento = Proforma::with('detalles')->where('id',$docId)->first();

        } else if ($tipoDoc == $tipoNotaVenta) {

            $documento = NotaVenta::with('detalles')->where('id',$docId)->first();
        } else {
            return response('Not found',404);
        }

        $items = $documento->detalles;

        $items->map(function($item) use($bodega) {

            $existencia = Bodega::getExistTotalPT($item->producto_id,$bodega);
            $item['existencia'] = $existencia;
        });

        return response($items,200);
    }
}
