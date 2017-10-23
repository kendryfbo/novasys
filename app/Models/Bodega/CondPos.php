<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class CondPos extends Model
{
    protected $table = 'cond_pos';
    protected $fillable = ['posicion_id', 'tipo_id', 'opcion_id', 'activo'];

    static function posicion() {

        return $this->belongsTo('App\Models\Bodega\posicion','posicion_id');
    }

    static function tipo() {

        return $this->belongsTo('App\Models\Bodega\CondPosTipo','tipo_id');
    }
}
