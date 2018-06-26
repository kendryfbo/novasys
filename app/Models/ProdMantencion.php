<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\TipoFamilia;

class ProdMantencion extends Model
{
    protected $table = 'prod_mantencion';
    protected $fillable = ['codigo', 'descripcion', 'familia_id', 'mansubfam_id', 'unimed_id', 'stock_min', 'activo'];

    /*
    |
    | Static Functions
    |
    */
    static function getArrayOfAllActiveWithLastPrice() {

        $tipo = TipoFamilia::getRepuestoID();

		return DB::select('SELECT i.id,i.codigo,i.descripcion,(select unidad from unidades where i.unimed_id=id) as unidad_med, '.$tipo.' as tipo_id,IFNULL(ocd.precio,0) as precio FROM prod_mantencion as i left join orden_compra_detalles as ocd on i.id=ocd.item_id AND ocd.tipo_id='.$tipo.'
        AND ocd.id=(SELECT MAX(id) FROM orden_compra_detalles as subocd where subocd.item_id=ocd.item_id) WHERE i.activo=1');

	}

    /*
    |
    |   Relationships
    |
    */

    public function familia() {

        return $this->belongsTo('App\Models\Familia','familia_id');
    }
    public function unidad() {

        return $this->belongsTo('App\Models\Unidad','unimed_id');
    }
}
