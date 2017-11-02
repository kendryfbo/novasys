<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class PalletMedida extends Model
{
    protected $table = 'pallet_medida';

    static function getAllActive() {

        return self::all()->where('activo',1);
    }
}
