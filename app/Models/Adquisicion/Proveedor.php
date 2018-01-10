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

        return self::all()->where('activo',1);
    }

    public function formaPago() {

        return $this->belongsTo('App\Models\Adquisicion\FormaPagoProveedor','fp_id');
    }

}
