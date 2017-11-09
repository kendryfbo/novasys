<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class IngresoTipo extends Model
{
    protected $table = 'ingreso_tipo';
    protected $fillable = ['descripcion', 'activo'];

}
