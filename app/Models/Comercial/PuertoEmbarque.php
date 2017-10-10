<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class PuertoEmbarque extends Model
{
  protected $table = 'puerto_embarque';
  protected $fillable = ['nombre', 'direccion', 'tipo', 'comuna', 'ciudad', 'fono', 'activo'];

  static function getAllActive() {

      return self::all()->where('activo',1);
  }
  
}
