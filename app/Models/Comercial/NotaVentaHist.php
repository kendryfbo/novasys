<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class NotaVentaHist extends Model
{
  protected $table = 'nv_hist';

  protected $fillable = ['numero','cv_id','cliente_id','cond_pago','version','vendedor_id','orden_compra','despacho',
							'aut_comer','aut_contab','sub_total','descuento','neto','iva','iaba','total',
							'peso_neto','peso_bruto','volumen','user_id','fecha_emision','fecha_despacho'];
}
