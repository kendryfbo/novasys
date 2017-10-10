<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
  protected $fillable = ['descripcion', 'activo'];

  static function getAllActive() {

    return self::all()->where('activo',1);
  }

}
