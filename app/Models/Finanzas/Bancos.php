<?php

namespace App\Models\Finanzas;

use Illuminate\Database\Eloquent\Model;

class Bancos extends Model
{
    protected $table = 'bancos';

    protected $fillable = ['nombre_banco', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }
}
