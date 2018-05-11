<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class PalletMedida extends Model
{
    const BAJO = 1; // correesponde al ID de Medida BAJO en tabla pallet_medida;
    const ALTO = 2; // correesponde al ID de Medida ALTO en tabla pallet_medida;

    protected $table = 'pallet_medida';

    static function getAllActive() {

        return self::all()->where('activo',1);
    }

    static function altoID() {

        return self::ALTO;
    }

    static function bajoID() {

        return self::BAJO;
    }
}
