<?php

namespace App\Models\Adquisicion;

use Illuminate\Database\Eloquent\Model;

class OrdenCompraTipo extends Model
{
    protected $table = 'orden_compra_tipos';

    protected $fillable = ['descripcion', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }
}
