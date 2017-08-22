<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class GuiaDespachoDetalle extends Model
{

  protected $fillable = [
    'guia_id', 'item', 'producto_id', 'descripcion', 'cantidad'
  ];

  public function guiaDespacho() {

    return $this->belongsTo(GuiaDespacho::class,'guia_id');
  }

  public function producto() {

    return $this->belongsTo('App\Models\Producto');
  }
}
