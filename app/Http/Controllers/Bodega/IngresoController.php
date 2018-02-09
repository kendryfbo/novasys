<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\Insumo;
use App\Models\Producto;
use App\Models\Premezcla;
use App\Models\Bodega\Ingreso;
use App\Models\Adquisicion\Area;
use App\Models\Bodega\IngresoTipo;
use App\Models\Config\StatusDocumento;
use App\Models\Adquisicion\OrdenCompra;
use App\Models\Produccion\TerminoProceso;
use App\Models\Adquisicion\OrdenCompraDetalle;

class IngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statusCompleta = StatusDocumento::completaID();
        $ingresos = Ingreso::with('usuario','tipo','status')->where('status_id','!=',$statusCompleta)->get();
        $ingresosProcesados = Ingreso::with('usuario','tipo','status')->where('status_id','=',$statusCompleta)->get();

        return view('bodega.ingreso.index')->with([
            'ingresos' => $ingresos,
            'ingresosProcesados' => $ingresosProcesados
        ]);
    }

    public function indexPendingOC()
    {
        $bodega = Area::bodegaID();
        $statusCompleta = StatusDocumento::completaID();

        $ordenesCompra = OrdenCompra::with('detalles','proveedor')
                            ->where('aut_contab',1)
                            ->where('area_id',$bodega)
                            ->where('status_id','!=',$statusCompleta)->get();

        return view('bodega.ingreso.indexPendingOC')->with([
            'ordenesCompra' => $ordenesCompra
        ]);
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
    // Crear Ingreso Manual Materia Prima
    public function createIngManualMP()
    {
        $tipoIngreso = IngresoTipo::manualID();
        $tipoProd = config('globalVars.MP');
        $insumos = Insumo::getAllActive();
        $fecha = Carbon::now()->toDateString();

        return view('bodega.ingreso.createIngManualMP')->with([
            'insumos' => $insumos,
            'tipoIngreso' => $tipoIngreso,
            'tipoProd' => $tipoProd,
            'fecha' => $fecha,
        ]);

    }
    // Crear Ingreso Manual Premezcla
    public function createIngManualPM()
    {
        $tipoIngreso = IngresoTipo::manualID();
        $tipoProd = config('globalVars.PP');
        $premezclas = Premezcla::getAllActive();
        $fecha = Carbon::now()->toDateString();

        return view('bodega.ingreso.createIngManualPM')->with([
            'premezclas' => $premezclas,
            'tipoIngreso' => $tipoIngreso,
            'tipoProd' => $tipoProd,
            'fecha' => $fecha,
        ]);

    }
    // Crear Ingreso desde Orden de Compra
    public function createIngOC(Request $request)
    {
        $numero = $request->numero;
        $bodega = Area::bodegaID();
        $tipoIngreso = IngresoTipo::ordenCompraID();
        $statusCompleta = StatusDocumento::completaID();

        $ordenCompra = OrdenCompra::with('detalles','proveedor')
                            ->where('numero',$numero)
                            ->where('aut_contab',1)
                            ->where('area_id',$bodega)
                            ->where('status_id','!=',$statusCompleta)->first();

        $fecha = Carbon::now()->toDateString();

        return view('bodega.ingreso.createIngOC')->with([
            'ordenCompra' => $ordenCompra,
            'tipoIngreso' => $tipoIngreso,
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
    // Guardar Ingreso Manual Materia Prima
    public function storeIngManualMP(Request $request)
    {

        $this->validate($request,[
            'descripcion' =>'required',
            'tipo_ingreso' => 'required',
            'tipo_prod' => 'required',
            'fecha' => 'required|date',
            'items' => 'required',
        ]);

        $ingreso = Ingreso::register($request);
        $msg = "Ingreso N°". $ingreso->numero . " ha sido Creada.";

        return redirect()->route('ingreso')->with(['status' => $msg]);
    }
    // Guardar Ingreso Manual Premezcla
    public function storeIngManualPM(Request $request)
    {

        $this->validate($request,[
            'descripcion' =>'required',
            'tipo_ingreso' => 'required',
            'tipo_prod' => 'required',
            'fecha' => 'required|date',
            'items' => 'required',
        ]);

        $ingreso = Ingreso::register($request);
        $msg = "Ingreso N°". $ingreso->numero . " ha sido Creada.";

        return redirect()->route('ingreso')->with(['status' => $msg]);
    }

    // Guardar Ingreso Orden de Compra
    public function storeIngFromOC(Request $request)
    {
        $this->validate($request,[
            'tipo_ingreso' => 'required',
            'ordenCompra' => 'required',
            'fecha' => 'required|date',
            'items' => 'required',
        ]);

        $ingreso = Ingreso::registerFromOC($request);
        $msg = "Ingreso N°". $ingreso->numero . " ha sido Creada.";

        return redirect()->route('ingreso')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bodega\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
        $ingreso = Ingreso::with('detalles','tipo','status')->where('numero',$numero)->first();
        //dd($ingreso);
        return view('bodega.ingreso.show')->with(['ingreso' => $ingreso]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bodega\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function edit(Ingreso $ingreso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bodega\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ingreso $ingreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bodega\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingreso $ingreso)
    {
        if (!$ingreso->statusPendiente()) {

            $msg = 'Ingreso Nº' . $ingreso->numero . ' No puede ser eliminado ya que fue procesado.';
        } else {

            $ingreso->delete();
            $msg = 'Ingreso Nº' . $ingreso->numero . ' ha sido Eliminado.';
        }

        return redirect()->route('ingreso')->with([
            'status' => $msg
        ]);
    }
}
