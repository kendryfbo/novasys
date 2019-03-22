<?php

namespace App\Models\Adquisicion;

use DB;
use Illuminate\Database\Eloquent\Model;

class CostoProducto extends Model
{
    static function totalCostoProducto() {


        $dollar = self::getDollarValue();

        $query = "SELECT productos.codigo,productos.descripcion,(
        SELECT SUM(cantxcaja *
            (
                SELECT CASE WHEN moneda_id=1 THEN precio/".$dollar." WHEN moneda_id=2 THEN precio END AS precio
                FROM orden_compra_detalles ocd
                WHERE ocd.tipo_id=1 AND ocd.item_id=formula_detalles.insumo_id
                ORDER BY id DESC
                LIMIT 1
            )) AS total
            FROM formula_detalles
            WHERE formula_detalles.formula_id=formulas.id
        ) AS total
        FROM productos,formulas
        WHERE productos.id=formulas.producto_id";

        $results = DB::select(DB::raw($query));

        return $results;
    }

    static function getDollarValue() {

      //API to obtain daily dollar's value
      $apiUrl = 'https://mindicador.cl/api';
      //allow_url_fopen para usar file_get_contents
      if ( ini_get('allow_url_fopen') ) {
          $json = file_get_contents($apiUrl);
      } else {
          //cURL
          $curl = curl_init($apiUrl);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          $json = curl_exec($curl);
          curl_close($curl);
      }
      $dailyIndicators = json_decode($json);
      $dollar = $dailyIndicators->dolar->valor;

      return $dollar;
    }
}
