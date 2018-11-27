<?php

namespace App\Models\Finanzas;

use Illuminate\Database\Eloquent\Model;

class PagoIntl extends Model
{
    protected $table = 'pagos_intl';

    protected $fillable = ['monto', 'restante', 'fecha_abono', 'cliente_id', 'usuario_id', 'orden_despacho', 'docu_abono', 'status_id'];

    static function get() {

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
