<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FormulaDetalle extends Model
{

	protected $fillable = ['formula_id','insumo_id','descripcion','nivel_id','cantxuni','cantxcaja','cantxbatch','batch'];

	static function import($producto,$productoImport) {

		$formulaDetalle = Formula::where('producto_id',$productoImport)->first()->detalle()->get();
		$formulaImportId = Formula::where('producto_id', $producto)->first()->id;

		DB::transaction(function() use ($formulaDetalle,$formulaImportId) {

			FormulaDetalle::where('formula_id',$formulaImportId)->delete();

			foreach ($formulaDetalle as $detalle) {

				$importar = [
					'formula_id' => 2,
					'insumo_id' => $detalle->insumo_id,
					'descripcion' => $detalle->descripcion,
					'nivel_id' => $detalle->nivel_id,
					'cantxuni' => $detalle->cantxuni,
					'cantxcaja' => $detalle->cantxcaja,
					'cantxbatch' => $detalle->cantxbatch,
					'batch' => $detalle->batch
				];
				FormulaDetalle::create($importar);
			}
		});
	}

	public function formula() {

		return $this->belongsTo('App\Models\Formula','formula_id');
	}

	public function nivel() {

		return $this->belongsTo('App\Models\Nivel');
	}

	public function insumo() {

		return $this->belongsTo('App\Models\Insumo');
	}

}
