<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class PerfilAcceso extends Model
{
	protected $table = 'perfil_accesos';

	public function perfil() {

		return $this->belongsTo('App\Models\Config\Perfil','perfil_id');
	}

	public function acceso() {

		return $this->belongsTo('App\Models\Config\Acceso','acceso_id');
	}
}
