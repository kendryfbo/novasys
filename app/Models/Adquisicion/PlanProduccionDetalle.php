<?php

namespace App\Models\Adquisicion;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;

class PlanProduccionDetalle extends Model
{
    protected $fillable = ['plan_id', 'producto_id', 'cantidad'];
    protected $table = 'plan_produccion_detalles';


    /*
    |
    |  Relationships
    |
    */

    public function producto() {

      return $this->hasOne(Producto::class, 'id', 'producto_id');
    }
}
