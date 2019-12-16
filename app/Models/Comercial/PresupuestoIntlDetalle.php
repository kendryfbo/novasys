<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon;

class PresupuestoIntlDetalle extends Model {

    protected $fillable = ['presupuesto_id', 'month', 'amount'];
    protected $table = 'presup_intl_detalles';



    /*
    |
    |  Relationships
    |
    */

    public function meses() {

        return $this->belongsTo('App\Models\Mes','month');
    }

    public function Usuario() {

        return $this->belongsTo('App\Models\Config\Usuario','user_id');
    }
}
