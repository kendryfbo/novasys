<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;

class ProdPremDetalle extends Model
{
    protected $table = 'prod_prem_detalle';
    protected $fillable = ['prodprem_id', 'insumo_id', 'cantidad'];

    // Relationships

    public function produccionPremezcla() {

        return $this->belongsTo('App\Models\Produccion\ProduccionPremezcla','prodprem_id');
    }
    public function insumo() {

        return $this->belongsTo('App\Models\Insumo','insumo_id');
    }
}
