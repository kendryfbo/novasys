<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class PosCond extends Model
{
    protected $table = 'pos_cond';
    protected $fillable = ['posicion_id', 'tipo_id', 'opcion_id', 'activo'];

    static function posicion() {

        return $this->belongsTo('App\Models\Bodega\posicion','posicion_id');
    }

    static function tipo() {

        return $this->belongsTo('App\Models\Bodega\CondPosTipo','tipo_id');
    }
}
