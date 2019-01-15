<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;

class ProdMezDetalle extends Model
{
    protected $table = 'prod_mez_detalle';
    protected $fillable = ['prodmez_id', 'insumo_id', 'cantidad'];

    // Relationships

    public function produccionMezclado() {

        return $this->belongsTo('App\Models\Produccion\ProduccionPremezcla','prodprem_id');
    }
    public function insumo() {

        return $this->belongsTo('App\Models\Insumo','insumo_id');
    }
}
