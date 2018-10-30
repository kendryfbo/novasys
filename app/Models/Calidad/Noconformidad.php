<?php

namespace App\Models\Calidad;
use Illuminate\Database\Eloquent\Model;

class Noconformidad extends Model
{
	protected $table = 'no_conformidades';
	protected $fillable = ['estado_id', 'user_id', 'titulo', 'area_id', 'fecha_deteccion', 'fecha_implementacion', 'fecha_cierre', 'analisis_causa', 'accion_propuesta', 'seguimiento_accion', 'persona_detecta', 'npi', 'clausula', 'OAI', 'ORC', 'OPR', 'ORE', 'OPO', 'OBS', 'descripcion', 'solucion_sugerida', 'desde_id', 'para_id', 'status_id'];

	static function getAllActive() {

		return self::all()->where('status_id',1);
	}

	/*
	|
	| Relationships
	|
	*/

	public function estadonc()
	{
		return $this->hasOne('App\Models\Calidad\Estado', 'id', 'estado_id');
	}

	public function desde()
	{
		return $this->hasOne('App\Models\Config\Usuario', 'id', 'desde_id');
	}

	public function para()
	{
		return $this->hasOne('App\Models\Config\Usuario', 'id', 'para_id');
	}
	public function area()
	{
		return $this->hasOne('App\Models\Adquisicion\Area', 'id', 'area_id');
	}

}
