<?php

namespace App\Http\Controllers\Comercial;

use Carbon\Carbon;
use App\Models\Mes;
use App\Models\Comercial\PresupuestoIntl;
use App\Models\Comercial\PresupuestoIntlDetalle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PresupuestoIntlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $presupuestoIntl = PresupuestoIntl::get();

      return view('comercial.presupuestoAnualIntl.index')->with(['presupuestoIntl' => $presupuestoIntl]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      /*
      |
      */

        $meses = Mes::get();
        $year = Carbon::now()->format('Y');
        return view('comercial.presupuestoAnualIntl.create')->with(['meses' => $meses, 'year' => $year]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      //dd($request);

        $this->validate($request,[
          'year' => 'required'

        ]);

        $presupuestoIntl = PresupuestoIntl::register($request);

        return redirect()->route('presupuestoIntl');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\PlanOferta  $planOferta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $presupuestoIntl = PresupuestoIntl::find($id);
        $presupuestoIntlDetalle = PresupuestoIntlDetalle::where('presupuesto_id',$id)->get();

        return view('comercial.presupuestoAnualIntl.show')->with(['presupuestoIntl' => $presupuestoIntl, 'presupuestoIntlDetalle' => $presupuestoIntlDetalle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\PlanOferta  $planOferta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $meses = Mes::get();
      $year = \Carbon\Carbon::now()->format('Y');
      $presupuestoIntl = PresupuestoIntl::find($id);
      $presupuestoIntlDetalle = PresupuestoIntlDetalle::where('presupuesto_id',$id)->get();

      return view('comercial.presupuestoAnualIntl.edit')->with(['meses' => $meses, 'year' => $year, 'presupuestoIntlDetalle' => $presupuestoIntlDetalle,
      'presupuestoIntl' => $presupuestoIntl]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $this->validate($request,[
        'year' => 'required'

      ]);

      $presupuestoIntl = PresupuestoIntl::registerEdit($request);

      return redirect()->route('presupuestoIntl');
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


    }

}
