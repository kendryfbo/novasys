<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formato extends Model
{
    protected $fillable = ['descripcion','peso_uni','peso_neto','activo'];

    static function getAllActive() {

        return self::where('activo',1)->get();
    }

    public function producto() {

		return $this->hasMany('App\Models\Producto');
	}
}
