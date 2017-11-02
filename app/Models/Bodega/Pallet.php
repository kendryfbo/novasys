<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;


class Pallet extends Model
{
    protected $bodegaPT = 1;
    
    protected $fillable= ['numero', 'medida'];


    static function createFromProduccion($request) {


    }
}
