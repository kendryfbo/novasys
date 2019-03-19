<?php

namespace App\Models\Finanzas;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    CONST FORMA_PAGO_CHEQUE_DIA = 1; // ID cheque al dia
    CONST FORMA_PAGO_CHEQUE_FECHA = 2; // ID cheque a fecha

    protected $table = 'finanzas_forma_pago';
    protected $fillable = ['descripcion', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }

    static function getChequeDiaID() {

        return self::FORMA_PAGO_CHEQUE_DIA;
    }

    static function getChequeFechaID() {

        return self::FORMA_PAGO_CHEQUE_FECHA;
    }

}
