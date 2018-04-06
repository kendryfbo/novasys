<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    const PRODUCCION = 1; // corresponde al id de nivel en tabla niveles.
    const PREMIX = 2; // corresponde al id de nivel en tabla niveles.
    const BASE = 3; // corresponde al id de nivel en tabla niveles.

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
    
    static function baseID() {

        return self::BASE;
    }

	public function formulaDetalle() {

		return $this->hasMany('App\Models\FormulaDetalle');
	}
}
