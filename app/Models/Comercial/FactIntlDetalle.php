<?php

namespace App\Models\Comercial;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;

class FactIntlDetalle extends Model
{
  protected $fillable = [
    'factura_id', 'item', 'producto_id', 'codigo', 'descripcion', 'cantidad', 'precio', 'descuento',
    'sub_total', 'peso_neto', 'peso_bruto', 'volumen'];


    /*
    |
    | Relationships
    |
    */
    public function factura() {

        return $this->belongsTo(FacturaIntl::class,'factura_id');
    }

    public function producto() {

      return $this->belongsTo(Producto::class,'producto_id');
    }
}
