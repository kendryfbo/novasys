<?php

namespace App\Models\Calidad;
use Illuminate\Database\Eloquent\Model;

class DocCalidad extends Model
{
	protected $table = 'docs_pdf_sgc';

	protected $fillable = ['titulo','codigo','revision','area_id','user_id','fecha_ult_rev','ruta_directorio'];

	/*
	|
	| Relationships
	|
	*/

	public function usuario()
	{
		return $this->hasOne('App\Models\Config\Usuario', 'id', 'user_id');
	}
	public function area()
	{
		return $this->hasOne('App\Models\Adquisicion\Area', 'id', 'area_id');
	}

}
