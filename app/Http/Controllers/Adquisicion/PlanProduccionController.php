<?php

namespace App\Http\Controllers\Adquisicion;

use Excel;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Adquisicion\PlanProduccion;

class PlanProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $planesProduccion = PlanProduccion::with('usuario')->get();

        return view('adquisicion.planProduccion.index')->with(['planesProduccion' => $planesProduccion]);

        //return redirect()->route('crearPlanProduccion');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      /*
      |  Probar plan guardado con producto que se le elimino la formula
      */
        $productos = Producto::has('formula')->where('activo',1)->get();

        return view('adquisicion.planProduccion.create')->with(['productos' => $productos]);
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
          'descripcion' => 'required',
          'fecha_emision' => 'required',
          'items' => 'required'
        ]);
        $planProduccion = PlanProduccion::register($request);

        return redirect()->route('planProduccion');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adquisicion\PlanProduccion  $planProduccion
     * @return \Illuminate\Http\Response
     */
    public function show($id) // Toma en cuenta producto terminado existente
    {
        $planProduccion = PlanProduccion::with('detalles.producto')->find($id);

        return view('adquisicion.planProduccion.show')->with(['planProduccion' => $planProduccion]);
    }

    public function duplicate($id) {

      $planProduccionOrig = PlanProduccion::with('detalles')->find($id);

      if (!$planProduccionOrig) {

        return redirect()->back();
      }

      $planProduccion = PlanProduccion::registerDuplicate($planProduccionOrig);
      $productos = Producto::has('formula')->where('activo',1)->get();

      return $this->edit($planProduccion->id);
    }

    public function showAnalReqWithStock(Request $request) // Toma en cuenta producto terminado existente
    {
        if (!$request->plan_id) {
            return redirect()->back();
        }
        $planProduccion = PlanProduccion::find($request->plan_id);
        $items = $planProduccion->detalles;

        $plan = PlanProduccion::analisisRequerimientosConStock($items);
        $productos = $plan[0];
        $insumos = $plan[1];
        return view('adquisicion.planProduccion.showWithStock')
                ->with(['planProduccion' => $planProduccion,
                        'productos' => $productos,
                        'insumos' => $insumos,
                        'items' => $items]);
    }

    public function showAnalReqWithoutStock(Request $request) // NO Toma en cuenta producto terminado existente
    {

        if (!$request->plan_id) {
            return redirect()->back();
        }
        $planProduccion = PlanProduccion::find($request->plan_id);
        $items = $planProduccion->detalles;

        $plan = PlanProduccion::analisisRequerimientos($items);
        $productos = $plan[0];
        $insumos = $plan[1];

        return view('adquisicion.planProduccion.showWithoutStock')
                ->with(['planProduccion' => $planProduccion,
                        'productos' => $productos,
                        'insumos' => $insumos,
                        'items' => $items]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adquisicion\PlanProduccion  $planProduccion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productos = Producto::has('formula')->where('activo',1)->get();
        $planProduccion = PlanProduccion::with('detalles')->find($id);

        foreach ($planProduccion->detalles as $detalle) {
          $detalle->codigo = $detalle->producto->codigo;
          $detalle->descripcion = $detalle->producto->descripcion;
        }

        return view('adquisicion.planProduccion.edit')->with(['productos' => $productos,'planProduccion' => $planProduccion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adquisicion\PlanProduccion  $planProduccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
          'descripcion' => 'required',
          'fecha_emision' => 'required',
          'items' => 'required'
        ]);

        $planProduccion = PlanProduccion::registerEdit($request);

        return redirect()->route('planProduccion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adquisicion\PlanProduccion  $planProduccion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $planProduccion = PlanProduccion::destroy($id);

      $msg = "Plan Produccion N°". $id . " ha sido ser Eliminada.";

      return redirect()->route('planProduccion')->with(['status' => $msg]);
    }

    public function downloadExcelAnalReq(Request $request) {

        $planID = $request->plan_id;
        if (!$planID) {
          dd('no plan ID');
        }
        $planProduccion = PlanProduccion::find($planID);
        $items = $planProduccion->detalles;

        $plan = PlanProduccion::analisisRequerimientos($items);
        $productos = $plan[0];
        $insumos = $plan[1];
        
        return Excel::create('Analisis de Produccion', function($excel) use ($productos,$insumos) {
            $excel->sheet('Resumen', function($sheet) use ($productos,$insumos) {
                $sheet->loadView('documents.excel.reportAnalReqSheetResum')
                        ->with(['productos' => $productos,'insumos' => $insumos]);
                    });
            $excel->sheet('Por ubicacion', function($sheet) use ($productos,$insumos) {
                $sheet->loadView('documents.excel.reportAnalReqSheetByLocations')
                        ->with(['insumos' => $insumos]);
                    });
            $excel->sheet('Insumos', function($sheet) use ($insumos) {
                $sheet->loadView('documents.excel.reportAnalReqSheetInsumos')
                        ->with(['insumos' => $insumos]);
                    })->download('xlsx');
                })->download('xlsx');

    }
    public function downloadExcelAnalReqConStock(Request $request) {

        $planID = $request->plan_id;
        if (!$planID) {
          dd('no plan ID');
        }
        $planProduccion = PlanProduccion::find($planID);
        $items = $planProduccion->detalles;

        $plan = PlanProduccion::analisisRequerimientos($items);
        $productos = $plan[0];
        $insumos = $plan[1];

        return Excel::create('Analisis de Produccion', function($excel) use ($productos,$insumos) {
            $excel->sheet('Resumen', function($sheet) use ($productos,$insumos) {
                $sheet->loadView('documents.excel.reportAnalReqConStockSheetResum')
                        ->with(['productos' => $productos,'insumos' => $insumos]);
                    });
            $excel->sheet('Por ubicacion', function($sheet) use ($productos,$insumos) {
                $sheet->loadView('documents.excel.reportAnalReqSheetByLocations')
                        ->with(['insumos' => $productos[0]->stock_insumos]);
                    });
            $excel->sheet('Insumos', function($sheet) use ($insumos) {
                $sheet->loadView('documents.excel.reportAnalReqSheetInsumos')
                        ->with(['insumos' => $insumos]);
                    })->download('xlsx');
                })->download('xlsx');
    }
}
