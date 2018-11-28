<?php

namespace App\Models\Finanzas;

use Illuminate\Database\Eloquent\Model;

class PagoFactIntl extends Model
{
    protected $table = 'pagos_intl';

    protected $fillable = ['monto', 'fecha_abono', 'cliente_id', 'usuario_id', 'abono_id'];

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
