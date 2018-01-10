<?php

namespace App\Models\Finanzas;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $table = 'monedas';

    protected $fillable = ['descripcion', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }
}
