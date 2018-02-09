<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class StatusDocumento extends Model
{
    const PENDIENTE = 1; // corresponde al id de status Pendiente en tabla status_documento
    const INGRESADA = 2; // corresponde al id de status Ingresada en tabla status_documento
    const COMPLETA = 3; // corresponde al id de status Completa en tabla status_documento

    protected $table = 'status_documento';
    protected $fillable = ['descripcion', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }

    static function pendienteID() {

        return self::PENDIENTE;
    }
    static function ingresadaID() {

        return self::INGRESADA;
    }
    static function completaID() {

        return self::COMPLETA;
    }
}
