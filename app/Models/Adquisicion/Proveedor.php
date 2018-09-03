<?php

namespace App\Models\Adquisicion;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = [
        'rut', 'descripcion', 'abreviacion', 'direccion', 'comuna', 'ciudad', 'fono',
        'fax', 'giro', 'contacto', 'cargo', 'celular', 'email', 'fp_id', 'cto_cbrnza', 'email_cbrnza', 'activo'];

    static function getAllActive() {

        return self::where('activo',1)->get();
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint){
    return $query->whereHas($relation, $constraint)
                 ->with([$relation => $constraint]);
}
    /*
    |
    |   Relationships
    |
    */
    public function formaPago() {

        return $this->belongsTo('App\Models\Adquisicion\FormaPagoProveedor','fp_id');
    }

    public function ordenCompras() {

        return $this->hasMany('App\Models\Adquisicion\OrdenCompra','prov_id');
    }

}
