<?php

namespace App\Http\Controllers;

use App\Models\Formula;
use App\Models\Producto;
use App\Models\Familia;
use App\Models\Nivel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FormulaController extends Controller
{
    // tipo de familia MateriaPrima e Insumos
    protected $tipoFamilia = 1;
    // reemplazar por usuario de la aplicacion
    protected $usuario = 'USER_DEMO';

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
        // $productos = Producto::doesntHave('formula')->get();
        // $familias = Familia::where('tipo_id',$this->tipoFamilia)->get();
        // $niveles = Nivel::getAllActive();
        // return view('desarrollo.formulas.create2')
        //         ->with(['productos' => $productos,'familias' => $familias,'niveles' => $niveles]);

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
        //
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
        //
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
        $formulas = Formula::all()->where('generada',1);

        return view('desarrollo.formulas.autorization')->with(['formulas' => $formulas]);
    }

    public function autorizar(Formula $formula)
    {
        $formula->autorizado = true;
        $formula->autorizada_por = 'USER_DEMO';
        $formula->fecha_aut = Carbon::today();
        $formula->save();

        $msg = 'Formula de Producto: ' . $formula->producto->descripcion . ' Ha sido Autorizada.';

        return redirect(route('autorizationFormula'))->with(['status' => $msg]);
    }

    public function desautorizar(Formula $formula) {

        $formula->autorizado = false;
        $formula->autorizada_por = NULL;
        $formula->fecha_aut = NULL;
        $formula->save();

        $msg = 'Formula de Producto: ' . $formula->producto->descripcion . ' Ha sido Desautorizada.';

        return redirect(route('autorizationFormula'))->with(['status' => $msg]);
    }

    public function getFormula(Request $request)
    {

        $usuario = $this->usuario;

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
