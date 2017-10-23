<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class PosicionStatus extends Model
{
    protected $table = 'posicion_status';
    protected $fillable = ['descripcion', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }
}
