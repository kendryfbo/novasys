<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
    protected $table = 'codigos';

    static function getAll() {

        return Codigo::all();
    }

}
