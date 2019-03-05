<?php

namespace App\Models\Finanzas;

use Illuminate\Database\Eloquent\Model;

class ChequeCartera extends Model
{
    protected $table = 'cheques_cartera';

    protected $fillable = ['cliente_id', 'abono_id', 'numero_cheque','fecha_cobro', 'aut_cobro','usuario_id', 'banco_id', 'monto'];

    static function getAllActive() {

        return self::all();
    }

    /*
    |   Public functions
    */

    public function authorizeCC() {

        $this->aut_cobro = 1;
        $this->save();
    }


    /*
    |
    | Relationships
    |
    */

    public function clienteNac()
    {
        return $this->hasOne('App\Models\Comercial\ClienteNacional', 'id', 'cliente_id');
    }

    public function banco()
    {
        return $this->hasOne('App\Models\Finanzas\Bancos', 'id', 'banco_id');
    }
}
