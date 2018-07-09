<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class EnvioMail extends Model
{

    const LISTA_PROFORMA_ID = 1; // id de lista de mails

    protected $table = 'envio_mail';
    protected $fillable = ['descripcion', 'activo'];


    static function proformaMailID() {

        return self::LISTA_PROFORMA_ID;
    }
    /*
    |
    |   Relationships
    |
    */

    public function detalles() {

        return $this->hasMany('App\Models\Config\EnvioMailDetalle','envmail_id');
    }
}
