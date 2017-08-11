<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class MedioTransporte extends Model
{

  protected $table = 'medio_transportes';

  static function getAllActive() {

    return self::all()->where('activo',1);
  }
  
}
