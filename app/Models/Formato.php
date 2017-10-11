<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formato extends Model
{
    protected $fillable = ['descripcion','peso_uni','peso_neto','activo'];

    static function getAllActive() {

        return Formato::all()->where('activo',1);
    }

    public function producto() {

		return $this->hasMany('App\Models\Producto');
	}
}
