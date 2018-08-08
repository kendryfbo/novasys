<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{

    protected $table = 'pais';

    static function getAllActive() {

        return self::all()->where('activo',1);
    }

    /*
    |
    |   Relationships
    |
    */

    public function clientesIntls() {

        return $this->hasMany('App\Models\Comercial\ClienteIntl','pais_id');
    }
}
