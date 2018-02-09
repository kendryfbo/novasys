<?php

namespace App\Models\Adquisicion;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    const BODEGA = 5; // Corresponde a id de tabla area

    protected $fillable = ['descripcion', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }

    static function bodegaID() {

        return self::BODEGA;
    }
}
