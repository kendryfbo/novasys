<?php

namespace App\Models\Finanzas;

use Illuminate\Database\Eloquent\Model;

class AbonosIntl extends Model
{
    protected $table = 'abonos_intl';

    protected $fillable = ['monto', 'fecha_abono', 'cliente_id', 'usuario_id', 'orden_despacho'];

    static function getAllActive() {

        return self::all();
    }


    /*
	|
	| Relationships
	|
	*/

	public function clienteIntl()
	{
		return $this->hasOne('App\Models\Comercial\ClienteIntl', 'id', 'cliente_id');
	}

}
