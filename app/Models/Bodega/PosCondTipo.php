<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class PosCondTipo extends Model
{
    protected $table = 'pos_cond_tipo';

    static function getAllActive() {

        return self::all()->where('activo',1);
    }

    static function condicion() {

        return $thi->hasMany('App\models\Bodega\CondPos','tipo_id');
    }
}
