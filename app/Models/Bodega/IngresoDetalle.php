<?php

namespace App\Models\Bodega;

use DB;
use App\Models\Producto;
use App\Models\TipoFamilia;
use App\Models\Bodega\IngresoTipo;
use App\Models\Bodega\IngresoDetalle;
use Illuminate\Database\Eloquent\Model;

class IngresoDetalle extends Model
{
    protected $table = 'ingreso_detalle';
    protected $fillable = ['ing_id','tipo_id', 'item_id', 'fecha_ing', 'fecha_venc', 'lote', 'cantidad', 'por_procesar'];


    static function getProdIngrPendPorAlmacenar() {

        $ing    = (new Ingreso)->getTable();
        $ingDet = (new IngresoDetalle)->getTable();
        $prod   = (new Producto)->getTable();
        $tipoProd = TipoFamilia::productoTerminado()->id;
        $tipoIng = IngresoTipo::termProcID();
        $query = 'SELECT
        det.id as id,
        det.tipo_id as tipo_id,
        det.item_id as item_id,
        p.codigo as codigo,
        p.descripcion as descripcion,
        det.fecha_venc as fecha_venc,
        ing.tipo_id as ing_tipo_id,
        ing.id as ing_id,
        det.por_procesar as por_procesar
        FROM '.$ingDet.' as det, '.$ing.' as ing, '.$prod.' as p
        WHERE det.ing_id=ing.id AND det.item_id=p.id AND ing.tipo_id != '.$tipoIng.' AND det.tipo_id = '.$tipoProd.' AND det.por_procesar > 0';

        $detalles = DB::select(DB::raw($query));

        return $detalles;
    }
    /*
    |
    |     Relationship
    |
    */
    public function insumo() {

        return $this->belongsTo('App\Models\Insumo','item_id');
    }

    public function producto() {

        return $this->belongsTo('App\Models\Producto','item_id');
    }

    public function ingreso() {

        return $this->belongsTo('App\Models\Bodega\Ingreso','ing_id');
    }

    public function item() {

        switch ($this->tipo_id) {

            case TipoFamilia::insumo()->id:
                return $this->belongsTo('App\Models\insumo','item_id');
                break;

            case TipoFamilia::productoTerminado()->id:
                return $this->belongsTo('App\Models\Producto','item_id');
                break;
        }
    }
}
