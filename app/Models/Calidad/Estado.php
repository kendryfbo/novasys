<?php

namespace App\Models\Calidad;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{

	protected $table = 'nc_estados';


	const ENVIADA = 1; // corresponde al id de status Pendiente en tabla status_documento
	const CONTESTADA = 2; // corresponde al id de status Ingresada en tabla status_documento
	const SOLUCIONADA = 3; // corresponde al id de status Completa en tabla status_documento

	static function enviadaID() {

		return self::ENVIADA;
	}
	static function contestadaID() {

		return self::CONTESTADA;
	}
	static function solucionadaID() {

		return self::SOLUCIONADA;
	}
	/*
	|
	| Relationships
	|
	*/

}
