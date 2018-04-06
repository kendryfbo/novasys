<?php

namespace App\Http\Controllers;

use App\Models\Formula;
use App\Models\Producto;
use App\Models\Familia;
use App\Models\Insumo;
use App\Models\Nivel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FormulaController extends Controller
{
    // tipo de familia MateriaPrima e Insumos
    protected $tipoFamilia = 1;

    public function index()
    {
        $formulas = Formula::with('producto:id,descripcion')->get();
        return view('desarrollo.formulas.index')->with(['formulas' => $formulas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $productos = Producto::getAllActive();
        $familias = Familia::where('tipo_id',$this->tipoFamilia)->get();
        $niveles = Nivel::getAllActive();

        return view('desarrollo.formulas.create')
                ->with(['productos' => $productos,'familias' => $familias,'niveles' => $niveles]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function show(Formula $formula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function edit(Formula $formula)
    {
        $formula->load('detalle.insumo','producto.formato','detalle.nivel');

        $niveles = Nivel::getAllActive();
        $insumos = Insumo::getAllActive();

        return view('desarrollo.formulas.edit')
                ->with([
                    'formula' => $formula, 'niveles' => $niveles, 'insumos' => $insumos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Formula $formula)
    {

        $this->validate($request, [
            'batch' => 'required',
            'items' => 'required',
        ]);

        $formula = Formula::registerEdit($request,$formula->id);
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

    public function generate(Request $request)
    {
        $this->validate($request,[
            'formula' => 'required'
        ]);

        $formula = Formula::find($request->formula);
        $formula->generada = true;
        $formula->generada_por = 'USER-DEMO';
        $formula->fecha_gen = Carbon::today();

        $formula->save();

        $msg = 'Formula de Producto: ' . $formula->producto->descripcion . ' Ha sido Generada.';

        return redirect(route('formulas'))->with(['status' => $msg]);

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

        $datos = [
            'formato' => $producto->formato,
            'formula_id' => $producto->formula->id
        ];

        return $datos;
    }
}
