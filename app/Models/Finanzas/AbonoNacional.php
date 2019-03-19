<?php

namespace App\Models\Finanzas;

use App\Models\Config\StatusDocumento;
use Illuminate\Database\Eloquent\Model;

class AbonoNacional extends Model
{
    protected $table = 'abonos_nacional';

    protected $fillable = ['monto', 'restante', 'fecha_abono', 'cliente_id', 'usuario_id', 'orden_despacho', 'docu_abono', 'status_id', 'formaPago_id', 'banco_id', 'fecha_cobro'];

    static function getAllActive() {

        return self::all();
    }

    /* Public functions */

    public function updateStatus() {

        if ($this->monto == $this->restante) {

            $this->status_id = StatusDocumento::pendienteID();
        } else if($this->restante <= 0) {

            $this->status_id = StatusDocumento::completaID();
        } else {

            $this->status_id = StatusDocumento::ingresadaID();
        }

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
