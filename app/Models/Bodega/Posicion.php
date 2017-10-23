<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class Posicion extends Model
{
    protected $table = 'posicion';
    protected $fillable = ['bodega_id', 'bloque', 'columna', 'estante', 'medida', 'status_id', 'pallet_id'];

    public function condicion() {

        return $this->hasOne('App\Models\Bodega\CondPos','posicion_id');
    }
}
