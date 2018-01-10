<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\FormulaDetalle;

class Formula extends Model
{

	protected $fillable = ['producto_id','generada','generada_por','autorizado','autorizado_por','cant_batch'];

	// static methods
	static function registerEdit($request,$formulaID) {

		$formula = DB::transaction(function() use($request,$formulaID){

			$batch = $request->batch;
			$items = $request->items;

			$formula = Formula::where('id',$formulaID)->first();
			$formula->cant_batch = $batch;
			$formula->generada = 1; 			// Se genera automaticamente mientras se implementa generacion
			$formula->autorizado = null;
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
					'nivel_id' => $item->nivel_id,
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

	// Relationships
	public function detalle() {

		return $this->hasMany('App\Models\FormulaDetalle');
	}

    public function producto() {

		return $this->belongsTo('App\Models\Producto');
	}

}
