<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class CondPosTipo extends Model
{
    protected $table = 'cond_pos_tipo';

    static function getAllActive() {

        return self::all()->where('activo',1);
    }


    static function condicion() {

        return $thi->hasMany('App\models\Bodega\CondPos','tipo_id');
    }
}
