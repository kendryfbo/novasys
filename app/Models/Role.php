<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function usuarios()
	{
		return $this->hasMany('App\Models\Usuario');
	}

	Public function permisos()
	{
		return $this->hasMany('App\Models\Permiso');
	}
}
