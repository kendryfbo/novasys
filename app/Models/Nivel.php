<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveles';

    static function getAllActive() {

        return Nivel::all()->where('activo',1);
    }

	public function formulaDetalle() {

		return $this->hasMany('App\Models\FormulaDetalle');
	}
}
