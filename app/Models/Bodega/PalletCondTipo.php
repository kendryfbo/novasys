<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class PalletCondTipo extends Model
{
    protected $table = 'pallet_cond_tipo';

    static function getAllActive() {

        return self::all()->where('activo',1);
    }
}
