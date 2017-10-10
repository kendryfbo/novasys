<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use Log;
class Acceso extends Model
{

  static function arrayOfAccess() {

    $accesos = Acceso::where('padre','root')->get()->toArray();
    // dd($accesos);
    $accesos = self::getChildrens($accesos);

      dd($accesos);
  }

  static private function getChildrens($padres) {

  $i = 0;
  foreach($padres as $padre) {
    
    $hijos = Acceso::where('padre',$padre['id'])->get()->toArray();

    $padres[$i]['hijos'] = self::getChildrens($hijos);
    $i++;
  }
  return $padres;
  }
}
