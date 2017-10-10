<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
	protected $table = 'perfiles';

	public function usuarios() {

		return $this->hasMany('App\Models\Config\Usuario','perfil_id');
	}

	public function accesos() {

		return $this->HasMany('App\Models\Config\PerfilAcceso','perfil_id');
	}
}
