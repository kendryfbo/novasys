<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
	protected $table = 'canales';


	static function getAllActive() {

		return self::all()->where('activo',1);
	}
}
