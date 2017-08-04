<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class NotaVentaHistDet extends Model
{

  protected $table = 'nv_hist_det';

  protected $fillable = ['nv_id', 'item', 'producto_id', 'descripcion', 'cantidad', 'precio', 'descuento', 'sub_total'];
}
