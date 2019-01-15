<?php

namespace App\Models\Adquisicion;

use Illuminate\Database\Eloquent\Model;

class OrdenCompraDetalle extends Model
{
    protected $fillable = ['oc_id', 'tipo_id' , 'item_id', 'codigo', 'descripcion',
    'unidad', 'cantidad','moneda_id', 'moneda', 'precio', 'sub_total', 'recibidas'];


    /*
    | Relationships
    */
    public function insumo() {

        return $this->belongsTo('App\Models\Insumo','item_id');
    }
}
