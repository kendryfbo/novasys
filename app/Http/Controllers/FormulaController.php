<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Nivel;
use App\Models\Insumo;
use App\Models\Familia;
use App\Models\Formula;
use App\Models\Producto;
use App\Models\Premezcla;
use App\Models\Reproceso;
use App\Models\TipoFamilia;
use Illuminate\Http\Request;

class FormulaController extends Controller
{

    public function index()
    {
        $formulas = Formula::with('producto:id,descripcion')->get(['id','producto_id','generada','generada_por','fecha_gen','autorizado','autorizada_por','fecha_aut']);

        return view('desarrollo.formulas.index')->with(['formulas' => $formulas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::with('formato')->doesntHave('formula')->where('activo',1)->get();
        $insumos = Insumo::getAllActive();
        $niveles = Nivel::getAllActive();
        $premezclas = Premezcla::getAllActive();
        $reprocesos = Reproceso::getAllActive();

        return view('desarrollo.formulas.create')
                ->with(['productos' => $productos,
                        'insumos' => $insumos,
                        'niveles' => $niveles,
                        'premezclas' => $premezclas,
                        'reprocesos' => $reprocesos]);
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
            'productoID' => 'required',
            //'premezclaID' => 'required',
            //'reprocesoID' => 'required',
            'cantBatch' => 'required',
            'items' => 'required'
        ]);

        $formula = Formula::register($request);
        $msg = 'Formula id:'. $formula->id . ' ha sido Creada.';

        return redirect()->route('formulas')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formula = Formula::with('detalle.insumo','producto.formato','detalle.nivel','premezcla','reproceso')->where('id',$id)->first();

        return view('desarrollo.formulas.show')->with(['formula' => $formula]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formula = Formula::with('detalle.insumo','producto.formato','detalle.nivel')->where('id',$id)->first();
        $niveles = Nivel::getAllActive();
        $insumos = Insumo::getAllActive();
        $premezclas = Premezcla::getAllActive();
        $reprocesos = Reproceso::getAllActive();

        return view('desarrollo.formulas.edit')
                ->with(['formula' => $formula,
                        'niveles' => $niveles,
                        'insumos' => $insumos,
                        'premezclas' => $premezclas,
                        'reprocesos' => $reprocesos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $this->validate($request,[
            'productoID' => 'required',
            //'premezclaID' => 'required',
            //'reprocesoID' => 'required',
            'cantBatch' => 'required',
            'items' => 'required'
        ]);

        $formula = Formula::registerEdit($request,$id);
        $msg = 'Formula id:'. $formula->id . ' ha sido editada.';

        return redirect()->route('formulas')->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formula $formula)
    {
        //
    }

    public function autorization()
    {
        $formulas = Formula::where('generada',1)->whereNull('autorizado')->get();

        return view('desarrollo.formulas.authorization')->with(['formulas' => $formulas]);
    }

    public function showForAuth($id) {

        $formula = Formula::with('producto','detalle.nivel')->find($id);

        return view('desarrollo.formulas.authorize')->with(['formula' => $formula]);
    }

    public function autorizar(Formula $formula)
    {
        $formula->autorizado = true;
        $formula->autorizada_por = auth()->user()->user;
        $formula->fecha_aut = Carbon::today();
        $formula->save();

        $msg = 'Formula de Producto: ' . $formula->producto->descripcion . ' Ha sido Autorizada.';

        return redirect(route('autorizacionFormula'))->with(['status' => $msg]);
    }

    public function desautorizar(Formula $formula) {

        $formula->autorizado = false;
        $formula->autorizada_por = auth()->user()->user;
        $formula->fecha_aut = Carbon::today();
        $formula->save();

        $msg = 'Formula de Producto: ' . $formula->producto->descripcion . ' Ha sido Desautorizada.';

        return redirect(route('autorizacionFormula'))->with(['status' => $msg]);
    }

    public function getFormula(Request $request)
    {

        $usuario = $request->user()->id;

        if (!$request->producto) {
            return 'ERROR';
        }

        $producto = Producto::find($request->producto);

        if (!$producto->hasFormula())
        {
            Formula::create([
                'producto_id' => $producto->id,
                'cant_batch' => 1
            ]);
        };
        //dd($datos);
        $datos = [
            'formato' => $producto->formato,
            'formula_id' => $producto->formula->id
        ];

        return $datos;
    }
}
