<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;

class ProdEnvDetalle extends Model
{
        protected $table = 'prod_env_detalle';
        protected $fillable = ['prodenv_id', 'insumo_id', 'cantidad'];

        /*
        |
        | Relationships
        |
        */
        public function ProduccionEnvasado() {

            return $this->belongsTo('App\Models\Produccion\ProduccionEnvasado','prodenv_id');
        }
        public function insumo() {

            return $this->belongsTo('App\Models\Insumo','insumo_id');
        }
}
