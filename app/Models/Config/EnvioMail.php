<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class EnvioMail extends Model
{
    protected $table = 'envio_mail';

    protected $fillable = ['descripcion', 'activo'];

    /*
    |
    |   Relationships
    |
    */

    public function detalles() {

        $this->hasMany('App\Models\Config\EnvioMailDetalle','envmail_id');
    }
}
