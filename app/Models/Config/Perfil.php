<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\Config\PerfilAcceso;

class Perfil extends Model
{
	protected $table = 'perfiles';
	protected $fillable = ['nombre', 'descripcion', 'activo'];

	static function register($request) {

		return DB::transaction(function () use ($request) {


			$nombre = $request->nombre;
			$descripcion = $request->descripcion;
			$activo = $request->activo ? 1 : 0;

			$perfil = Perfil::Create([
				'nombre' => $nombre,
				'descripcion' => $descripcion,
				'activo' => $activo,
			]);

			foreach ($request->items as $item) {

				$item = json_decode($item);
				perfilAcceso::create([
					'perfil_id' => $perfil->id,
					'acceso_id' => $item->id,
					'acceso' => $item->access ? 1:0,
				]);
			}
			return $perfil;
		},5);
	}

	static function registerEdit($request,$id) {

		return DB::transaction(function () use ($request,$id) {

			$perfil = Perfil::find($id);
			$perfil->nombre = $request->nombre;
			$perfil->descripcion = $request->descripcion;
			$activo = $request->activo ? 1 : 0;
			$perfil->activo = $activo;
			$perfil->save();

			PerfilAcceso::where('perfil_id',$perfil->id)->delete();

			foreach ($request->items as $item) {

				$item = json_decode($item);
				perfilAcceso::create([
					'perfil_id' => $perfil->id,
					'acceso_id' => $item->id,
					'acceso' => $item->access ? 1:0,
				]);
			}
			return $perfil;
		},5);
	}

	/*
	*
	* RELATIONSHIPS
	*
	*/
	public function usuarios() {

		return $this->hasMany('App\Models\Config\Usuario','perfil_id');
	}

	public function accesos() {

		return $this->HasMany('App\Models\Config\PerfilAcceso','perfil_id');
	}
}
