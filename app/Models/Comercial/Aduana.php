<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class Aduana extends Model
{
  protected $fillable = ['rut', 'descripcion', 'direccion', 'ciudad', 'comuna', 'tipo', 'fono', 'activo'];

  static function getAllActive() {

    return self::all()->where('activo',1);
  }
}
