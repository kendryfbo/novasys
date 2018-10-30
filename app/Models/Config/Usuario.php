<?php

namespace App\Models\Config;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
	use Notifiable;

	protected $guard = 'web';

	protected $fillable = ['user','nombre', 'apellido', 'cargo', 'perfil_id', 'activo'];

	protected $hidden = ['pass'];


	public function perfil() {

		return $this->belongsTo('App\Models\Config\Perfil','perfil_id');
	}

	static function getAllActive() {

		return self::all()->where('activo',1);
	}

	// Overiding method to desable rememberTokenFeature
	public function setAttribute($key, $value)
	 {
    	$isRememberTokenAttribute = $key == $this->getRememberTokenName();
	    if (!$isRememberTokenAttribute)
	    {
	      parent::setAttribute($key, $value);
	    }
  	}

	public function haveAccessTo($acceso) {

		$acceso = $this->perfil()->first()->accesos()->where('nombre',$acceso)->first();

		if (is_null($acceso)) {
			return false;
		} else {

			return $acceso->acceso ? true : false;
		}
	}
}
