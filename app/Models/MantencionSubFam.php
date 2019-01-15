<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MantencionSubFam extends Model
{
    protected $table = 'mantencion_sub_familia';
    protected $fillable = ['codigo', 'descripcion', 'familia_id', 'activo'];
}
