<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formato extends Model
{
    protected $fillable = ['descripcion','unidad_med','peso','sobre','display','activo'];

    public function unidad() {

        return $this->belongsTo('App\Models\Unidad');

    }
}
