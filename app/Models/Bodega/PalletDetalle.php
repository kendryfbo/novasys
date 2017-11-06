<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class PalletDetalle extends Model
{
    protected $table = 'pallet_detalle';
    protected $fillable = ['pallet_id', 'tipo_id', 'item_id', 'codigo', 'descripcion', 'cantidad', 'fecha_venc', 'lote'];

    public function pallet() {

        return $this->belongsTo('App\Models\Bodega\Pallet','pallet_id');
    }
}
