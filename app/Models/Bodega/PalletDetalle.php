<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class PalletDetalle extends Model
{
    protected $table = 'pallet_detalle';
    protected $fillable = ['pallet_id', 'tipo_id', 'item_id', 'ing_tipo_id', 'ing_id', 'cantidad', 'fecha_ing', 'fecha_venc', 'lote'];


    /*
    |
    |     Static Functions
    |
    */

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

        $PT = config('globalVars.PT');
        $MP = config('globalVars.MP');
        $PP = config('globalVars.PP');

        if ($this->tipo_id == $PT) {

            return $this->belongsTo('App\Models\Producto','item_id');

        } else if ($this->tipo_id == $MP) {
            return $this->belongsTo('App\Models\Insumo','item_id');

        } else if ($this->tipo_id == $PP) {

            return $this->belongsTo('App\Models\Premezcla','item_id');

        } else {
            return null;
        }
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

        return $this->belongsTo('App\Models\Bodega\Ingreso','ing_id');
    }
}
