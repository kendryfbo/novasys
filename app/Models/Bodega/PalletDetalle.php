<?php

namespace App\Models\Bodega;

use App\Models\TipoFamilia;

use Illuminate\Database\Eloquent\Model;

class PalletDetalle extends Model
{
    protected $table = 'pallet_detalle';
    protected $fillable = ['pallet_id', 'tipo_id', 'item_id', 'ing_tipo_id', 'ing_id', 'cantidad', 'lote', 'fecha_ing', 'fecha_venc'];

    /*
    |
    |     Static Functions
    |
    */

    // descontar de detalle Pallet
    public function subtract($cantidad) {

        if ($this->cantidad < $cantidad) {
            dd('cantidad a restar es mayor a la existente');
        }

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

        $PT = TipoFamilia::getProdTermID();
        $MP = TipoFamilia::getInsumoID();
        $PR = TipoFamilia::getPremezclaID();
        $RP = TipoFamilia::getReprocesoID();

        if ($this->tipo_id == $PT) {

            return $this->belongsTo('App\Models\Producto','item_id');

        } else if ($this->tipo_id == $MP) {
            return $this->belongsTo('App\Models\Insumo','item_id');

        } else if ($this->tipo_id == $PR) {

            return $this->belongsTo('App\Models\Premezcla','item_id');

        } else if ($this->tipo_id = $RP){

            return $this->belongsTo('App\Models\Reproceso','item_id');
        } else {
            return null;
        }
    }

    public function insumo() {

        return $this->belongsTo('App\Models\Insumo','item_id');
    }
    public function premezcla() {

        return $this->belongsTo('App\Models\Premezcla','item_id');
    }
    public function reproceso() {

        return $this->belongsTo('App\Models\Reproceso','item_id');
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
