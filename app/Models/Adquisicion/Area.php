<?php

namespace App\Models\Adquisicion;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['descripcion', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }
}
