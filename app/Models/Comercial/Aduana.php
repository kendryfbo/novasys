<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class Aduana extends Model
{
  protected $fillable = ['rut', 'descripcion', 'direccion', 'ciudad', 'comuna', 'fono', 'activo'];

  static function getAllActive() {

    return self::all()->where('activo',1);
  }

  public function guiaDespacho() {

    return $this->hasMany(GuiaDespacho::class);
  }
}
