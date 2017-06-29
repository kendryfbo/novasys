<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class PerfilAcceso extends Model
{
	public function perfil() {

		return $this->belongsTo('App\Models\Config\Perfil','perfil_id');
	}
}
