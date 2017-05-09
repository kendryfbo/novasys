<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'unidades';

    public function formato() {

        return $this->hasMany('App\Models\Formato');
    }
}
