<?php

namespace App\Models\Finanzas;

use Illuminate\Database\Eloquent\Model;

class AbonoNacional extends Model
{
    protected $table = 'abonos_nacional';

    protected $fillable = ['monto', 'restante', 'fecha_abono', 'cliente_id', 'usuario_id', 'orden_despacho', 'docu_abono', 'status_id'];

    static function getAllActive() {

        return self::all();
    }


    /*
	|
	| Relationships
	|
	*/

	public function clienteNacional()
	{
		return $this->hasOne('App\Models\Comercial\ClienteNacional', 'id', 'cliente_id');
	}

}
