<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class EgresoTipo extends Model
{

    const TIPO_MANUAL         = 1; // // Corresponde a id de egreso manual en tabla egreso_tipo
    const TIPO_PROFORMA_ID        = 2; // // Corresponde a id de egreso por termino de proceso en tabla egreso_tipo
    const TIPO_NOTAVENTA_ID          = 3; // // Corresponde a id de egreso por orden de compra en tabla egreso_tipo
    const TIPO_TRASLADO_ID    = 4; // // Corresponde a id de egreso por devolucion en tabla egreso_tipo

    protected $table = 'egreso_tipo';
    protected $fillable = ['descripcion', 'activo'];

    static function manualID() {

        return self::TIPO_MANUAL;
    }
    static function profID() {

        return self::TIPO_PROFORMA_ID;
    }
    static function nvID() {

        return self::TIPO_NOTAVENTA_ID;
    }
    static function trasladoID() {

        return self::TIPO_TRASLADO_ID;
    }

}
