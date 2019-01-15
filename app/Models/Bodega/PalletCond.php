<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class PalletCond extends Model
{
    protected $table = 'pallet_cond';


    static function condicionNoExportable($opcion)
    {
        $tipoCond = 1; //id tipo de condicion

        $query = "SELECT pallet_id FROM pallet_cond WHERE tipo_id=" . . " AND opcion_id!=" . $opcion;
        
    }
}
