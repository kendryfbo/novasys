<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'unidades';

    static function getAllActive() {

        return Unidad::all()->where('activo',1);
    }
    
    public function formato() {

        return $this->hasMany('App\Models\Formato');
    }
}
