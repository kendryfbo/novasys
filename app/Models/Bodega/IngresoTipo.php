<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class IngresoTipo extends Model
{
    const TIPO_MANUAL    = 1; // // Corresponde a id de ingreso manual en tabla ingreso_tipo
    const TIPO_TERM_PROC = 2; // // Corresponde a id de ingreso por termino de proceso en tabla ingreso_tipo
    const TIPO_OC_ID     = 3; // // Corresponde a id de ingreso por orden de compra en tabla ingreso_tipo

    protected $table = 'ingreso_tipo';
    protected $fillable = ['descripcion', 'activo'];

    static function manualID() {

        return self::TIPO_MANUAL;
    }
    static function termProcID() {

        return self::TIPO_TERM_PROC;
    }
    static function ordenCompraID() {

        return self::TIPO_OC_ID;
    }
}
