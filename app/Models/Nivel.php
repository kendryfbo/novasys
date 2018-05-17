<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    const PRODUCCION = 1; // corresponde al id de nivel produccion en tabla niveles.
    const PREMIX = 2; // corresponde al id de nivel premix en tabla niveles.
    const MEZCLADO = 3; // corresponde al id de nivel mezclado en tabla niveles.

    protected $table = 'niveles';

    static function getAllActive() {

        return self::all()->where('activo',1);
    }

    static function produccionID() {

        return self::PRODUCCION;
    }

    static function premixID() {

        return self::PREMIX;
    }

    static function mezcladoID() {

        return self::MEZCLADO;
    }


    // Relationships

	public function formulaDetalle() {

		return $this->hasMany('App\Models\FormulaDetalle');
	}
}
