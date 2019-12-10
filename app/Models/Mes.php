<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    protected $table = 'meses';

    static function getAll() {

        return Mes::all();
    }

}
