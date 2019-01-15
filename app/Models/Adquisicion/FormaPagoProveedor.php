<?php

namespace App\Models\Adquisicion;

use Illuminate\Database\Eloquent\Model;

class FormaPagoProveedor extends Model
{
    protected $table = 'forma_pago_proveedor';
    protected $fillable = ['descripcion', 'dias', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }
}
