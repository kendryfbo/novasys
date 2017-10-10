<?php

namespace App\Models\Comercial;

use DB;
use App\Models\Comercial\Proforma;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comercial\GuiaDespachoDetalle;

class GuiaDespacho extends Model
{
  protected $fillable = [
    'proforma_id', 'numero', 'aduana_id', 'fecha', 'mn', 'booking', 'contenedor','sello', 'chofer', 'patente',
    'movil', 'prof', 'dus', 'peso_neto', 'peso_bruto', 'volumen', 'fecha_emision', 'user_id'
  ];

  public function detalles() {

    return $this->hasMany(GuiaDespachoDetalle::class,'guia_id');
  }

  public function proforma() {

    return $this->belongsTo(Proforma::class);
  }

  public function aduana() {

    return $this->belongsTo(Aduana::class);
  }

    static function register($request) {

        $guia = DB::transaction(function () use ($request){

            $proforma = Proforma::with('detalles')->where('numero',$request->proforma)->first();

            $guia = GuiaDespacho::create([
                'numero' => $request->numero,
                'proforma_id' => $proforma->id,
                'aduana_id' => $request->aduana,
                'fecha_emision' => $request->fecha,
                'mn' => $request->mn,
                'booking' => $request->booking,
                'contenedor' => $request->contenedor,
                'sello' => $request->sello,
                'chofer' => $request->chofer,
                'patente' => $request->patente,
                'movil' => $request->movil,
                'prof' => $request->prof,
                'dus' => $request->dus,
                'peso_neto' => $request->neto,
                'peso_bruto' => $request->bruto,
                'volumen' => $request->bruto,
                'nota' => $request->nota,
                'user_id' => $request->user()->id
            ]);

            $i = 0;

            foreach ($proforma->detalles as $detalle) {

                $i ++;

                GuiaDespachoDetalle::create([
                  'guia_id' => $guia->id,
                  'item' => $i,
                  'producto_id' => $detalle->producto_id,
                  'descripcion' => $detalle->descripcion,
                  'cantidad' => $detalle->cantidad
                ]);
            }

            return $guia;

        },5);

        return $guia;
    }
}
