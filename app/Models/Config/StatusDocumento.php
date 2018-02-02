<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class StatusDocumento extends Model
{
    protected $table = 'status_documento';
    protected $fillable = ['descripcion', 'activo'];

    static function getAllActive() {

        return self::all()->where('activo',1);
    }
}
