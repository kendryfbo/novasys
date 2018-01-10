<?php

namespace App\Models\Adquisicion;

use Illuminate\Database\Eloquent\Model;

class OrdenCompraStatus extends Model
{
    protected $table = 'orden_compra_status';

    protected $fillable = ['descripcion', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }
}
