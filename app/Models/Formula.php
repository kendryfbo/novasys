<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\Nivel;
use App\Models\FormulaDetalle;

class Formula extends Model
{

	protected $fillable = ['producto_id','premezcla_id', 'reproceso_id', 'generada','generada_por','autorizado','autorizado_por','cant_batch'];

	// static methods
	static function register($request) {

		$formula = DB::transaction(function() use($request){

			$productoID = $request->productoID;
			$premezclaID = $request->premezclaID;
			$reprocesoID = $request->reprocesoID;
			$cantBatch = $request->cantBatch;
			$generada = 1; // por determinar.
			$usuarioID = $request->user()->nombre;
			$fecha = ''; // por determinar.
			$autorizado = null;
			$items = $request->items;


			$formula = Formula::create([
				'producto_id' => $productoID,
				'premezcla_id' => $premezclaID,
				'reproceso_id' => $reprocesoID,
				'generada' => $generada,
				'generada_por' => $usuarioID,
				'fecha_gen' => $fecha,
				'autorizado' => $autorizado,
				'cant_batch' => $cantBatch,
			]);

			foreach ($items as $item) {

				$item = json_decode($item);

				FormulaDetalle::create([
					'formula_id' => $formula->id,
					'insumo_id' => $item->id,
					'descripcion' => $item->descripcion,
					'nivel_id' => $item->nivel->id,
					'cantxuni' => $item->cantxuni,
					'cantxcaja' => $item->cantxcaja,
					'cantxbatch' => $item->cantxbatch,
					'batch' => $formula->cant_batch
				]);
			};
			return $formula;
		},5);
		return $formula;
	}

	static function registerEdit($request,$formulaID) {

		$formula = DB::transaction(function() use($request,$formulaID){

			$productoID = $request->productoID;
			$premezclaID = $request->premezclaID;
			$reprocesoID = $request->reprocesoID;
			$cantBatch = $request->cantBatch;
			$generada = 1; // por determinar.
			$usuarioID = $request->user()->id;
			$fecha = ''; // por determinar.
			$autorizado = null;
			$items = $request->items;

			$formula = Formula::where('id',$formulaID)->first();

			$formula->cant_batch = $cantBatch;
			$formula->generada = $generada; 			// Se genera automaticamente mientras se implementa generacion
			$formula->autorizado = $autorizado;
			$formula->autorizada_por = null;
			$formula->fecha_aut = null;

			$formula->save();

			FormulaDetalle::where('formula_id',$formula->id)->delete();

			foreach ($items as $item) {

				$item = json_decode($item);

				FormulaDetalle::create([
					'formula_id' => $formula->id,
					'insumo_id' => $item->insumo_id,
					'descripcion' => $item->descripcion,
					'nivel_id' => $item->nivel->id,
					'cantxuni' => $item->cantxuni,
					'cantxcaja' => $item->cantxcaja,
					'cantxbatch' => $item->cantxbatch,
					'batch' => $formula->cant_batch
				]);
			};
			return $formula;
		},5);
		return $formula;
	}

	static function getDataForProdEnvasado() {

		$nivelProd = Nivel::produccionID();
		$nivelMezclado = Nivel::mezcladoID();
		$nivelPremix = Nivel::premixID();

		$formulas = self::with('producto','reproceso')->where('autorizado',1)->get();

		$formulas->load(['detalle' => function ($query) use ($nivelProd){
			$query->where('nivel_id',$nivelProd);
		},'detalle.insumo','detalle.nivel']);

		foreach ($formulas as &$formula) {

			$detalleFormula = FormulaDetalle::where('formula_id',$formula->id)
                ->whereIn('nivel_id',[$nivelMezclado,$nivelPremix])
                ->get();

            $totalReproceso = $detalleFormula->sum('cantxbatch');
			$formula->cantxbatch_prodMez = abs(round($totalReproceso,2));
		}

		return $formulas;
	}


	static function getAllAuthorized() {

		return self::where('autorizado',1)->get();
	}

	// public functions
	public function authorized() {

		return $this->where('autorizado',1)->get();
	}

	/*
	|
	| Relationships
	|
	*/

	public function detalle() {

		return $this->hasMany('App\Models\FormulaDetalle');
	}

    public function producto() {

		return $this->belongsTo('App\Models\Producto');
	}

	public function premezcla() {

		return $this->belongsTo('App\Models\Premezcla','premezcla_id');
	}

	public function reproceso() {

		return $this->belongsTo('App\Models\Reproceso');
	}

}
