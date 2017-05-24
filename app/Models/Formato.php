<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formato extends Model
{
    protected $fillable = ['descripcion','unidad_med','peso','sobre','display','activo'];

    static function getAllActive() {

        return Formato::all()->where('activo',1);
    }

    public function unidad() {

        return $this->belongsTo('App\Models\Unidad');

    }

    public function producto() {

		return $this->hasMany('App\Models\Producto');
	}
}
