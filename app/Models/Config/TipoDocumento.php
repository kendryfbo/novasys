<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{

    const TIPO_PROFORMA_ID = 1; // Corresponde a id tipo de documento Proforma en tabla tipo_documento.
    const TIPO_NOTAVENTA_ID = 2; // Corresponde a id tipo de documento Nota de Venta en tabla tipo_documento.

    protected $table = 'tipo_documento';
    protected $fillable = ['descripcion', 'activo'];

    static function proformaID() {

        return self::TIPO_PROFORMA_ID;
    }
    static function notaVentaID() {

        return self::TIPO_NOTAVENTA_ID;
    }
}
