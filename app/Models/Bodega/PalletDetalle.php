<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class PalletDetalle extends Model
{
    protected $table = 'pallet_detalle';
    protected $fillable = ['pallet_id', 'tipo_id', 'item_id', 'ing_tipo_id', 'ing_id', 'cantidad', 'fecha_venc', 'lote'];


    // descontar de detalle Pallet
    public function subtract($cantidad) {

        $this->cantidad = $this->cantidad - $cantidad;

        $this->save();

        $this->deleteIfEmpty();
    }

    // si cantidad es 0 Eliminar
    private function deleteIfEmpty() {

        $total = $this->cantidad;

        if ($total <= 0) {

            $this->delete();

            return true;
        }

        return false;
    }



    /*
    |    Relationships
    */
    public function pallet() {

        return $this->belongsTo('App\Models\Bodega\Pallet','pallet_id');
    }

    public function producto() {

        return $this->belongsTo('App\Models\Producto','item_id');
    }

    public function insumo() {

        return $this->belongsTo('App\Models\Insumo','item_id');
    }

    public function produccion() {

        return $this->belongsTo('App\Models\Produccion\TerminoProceso','ing_id');
    }


    // cambiar
    public function tipo() {

        return $this->belongsTo('App\Models\Bodega\IngresoTipo','ing_tipo_id');
    }

    // para acceso a bodega
    public function ingreso() {

        return $this->produccion();
    }
}
