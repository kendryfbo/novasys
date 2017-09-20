<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class NotaDebitoNac extends Model
{
    protected $table = 'nota_debito_nac';
    protected $fillable = ['numero', 'num_nc', 'fecha', 'nota', 'neto', 'iva', 'iaba', 'total', 'user_id'];
}
