<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
  protected $fillable = ['descripcion', 'activo'];

  static function getAllActive() {

    return self::where('activo', 1);
  }
  
}
