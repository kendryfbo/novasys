<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class ClausulaVenta extends Model
{
  protected $table = 'clausula_ventas';

  static function getAllActive() {

    return self::all()->where('activo',1);
  }
  
}
