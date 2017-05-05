<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sabor extends Model
{
	protected $table = 'sabores';
    protected $fillable = ['descripcion','descrip_ing','activo'];
}
