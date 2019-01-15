<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class PosicionStatus extends Model
{
    // Constancia
	const DESHABILITADO_ID = 1; // correspondiente a id posicion deshabilitada tabla posicion_status
	const DISPONIBLE_ID = 2; // correspondiente a id posicion disponible tabla posicion_status
	const OCUPADO_ID = 3;	 // correspondiente a id posicion ocupado tabla posicion_status
	const RESERVADO_ID = 4;	 // correspondiente a id posicion reservado tabla posicion_status
	const BLOQUEADO_ID = 5;	 // correspondiente a id posicion bloqueado tabla posicion_status

    protected $table = 'posicion_status';
    protected $fillable = ['descripcion', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }

    static function disponible(){

        return self::where('id',2)->first();
    }
    static function ocupado(){

        return self::where('id',3)->first();
    }

    static function deshabilidatoID() {
        return self::DESHABILITADO_ID;
    }
    static function disponibleID() {
        return self::DISPONIBLE_ID;
    }
    static function ocupadoID() {
        return self::OCUPADO_ID;
    }
    static function reservadoID() {
        return self::RESERVADO_ID;
    }
    static function bloqueadoID() {
        return self::BLOQUEADO_ID;
    }
}
