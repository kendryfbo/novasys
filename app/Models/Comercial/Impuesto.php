<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{

    static function getIva() {

        return self::where('id',1)->first();
    }
}
