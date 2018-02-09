<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipo_documento';
    protected $fillable = ['descripcion', 'activo'];
}
