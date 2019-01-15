<?php

namespace App\Models\Comercial;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;

class ProformaDetalle extends Model
{
  protected $fillable = [
    'proforma_id', 'item', 'producto_id', 'codigo', 'descripcion', 'cantidad', 'precio', 'descuento',
    'sub_total', 'peso_neto', 'peso_bruto', 'volumen'];

  public function proforma() {

    return $this->belongsTo(Proforma::class);
  }
  public function producto() {

    return $this->belongsTo(Producto::class,'producto_id');
  }
}
