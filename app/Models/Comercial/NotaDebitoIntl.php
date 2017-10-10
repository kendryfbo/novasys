<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class NotaDebitoIntl extends Model
{
    protected $table = 'nota_debito_intl';
    protected $fillable = ['numero', 'num_nc', 'fecha', 'nota', 'fob', 'total', 'user_id'];
}
