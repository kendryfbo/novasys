<?php

namespace App\Models\Bodega;

use DB;
use Illuminate\Database\Eloquent\Model;

class IngresoTipo extends Model
{
    const TIPO_MANUAL           = 1; // // Corresponde a id de ingreso manual en tabla ingreso_tipo
    const TIPO_TERM_PROC        = 2; // // Corresponde a id de ingreso por termino de proceso en tabla ingreso_tipo
    const TIPO_OC_ID            = 3; // // Corresponde a id de ingreso por orden de compra en tabla ingreso_tipo
    const TIPO_DEV_ID           = 4; // // Corresponde a id de ingreso por devolucion en tabla ingreso_tipo
    const TIPO_PROD_PREM_ID     = 5; // // Corresponde a id de ingreso por Produccion de Premezcla en tabla ingreso_tipo
    const TIPO_PROD_MEZ_ID      = 6; // // Corresponde a id de ingreso por Produccion de Mezclado en tabla ingreso_tipo
    const TIPO_PROD_ENV_ID      = 7; // // Corresponde a id de ingreso por Produccion de Envasado en tabla ingreso_tipo

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
    static function devolucionID() {

        return self::TIPO_DEV_ID;
    }
    static function prodPremID() {

        return self::TIPO_PROD_PREM_ID;
    }
    static function prodMezID() {

        return self::TIPO_PROD_MEZ_ID;
    }
    static function prodEnvID() {

        return self::TIPO_PROD_ENV_ID;
    }
}
