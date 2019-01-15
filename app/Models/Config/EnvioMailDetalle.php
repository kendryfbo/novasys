<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class EnvioMailDetalle extends Model
{
    protected $table = 'envio_mail_detalles';
    protected $fillable = ['envmail_id', 'descripcion', 'mail', 'activo'];
}
