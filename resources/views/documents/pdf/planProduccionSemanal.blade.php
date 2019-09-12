
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Novasys 2.0</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
<!-- <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}"> -->
  <style>
          body {
               font-family: 'rockwell';
               font-size:9;
               }
          special. {
            font-size:19;
          }
  </style>
</head>
    <body>

      <table border="1" width="800">
          <tr>
            <td colspan="12" style="font-size: 22px;" height="25"><img src="../public/images/logonovafoods.png" width="120" height="40" align="left"><div align="center">{{$planProduccion->descripcion}}</div></td>
          </tr>
          <tr>
            <td align="center" width="7"><h5>MAQ.</h5></td>
            <td align="center"><strong>Lunes</strong> | {{ \Carbon\Carbon::parse($planProduccion->fecha_emision)->format('d-m-Y')}}</td>
            <td align="center" width="7"><h5>MAQ.</h5></td>
            <td align="center"><strong>Martes</strong> | {{ \Carbon\Carbon::parse($planProduccion->fecha_emision)->addDays(1)->format('d-m-Y')}}</td>
            <td align="center" width="7"><h5>MAQ.</h5></td>
            <td align="center"><strong>Miércoles</strong> | {{ \Carbon\Carbon::parse($planProduccion->fecha_emision)->addDays(2)->format('d-m-Y')}}</td>
            <td align="center" width="7"><h5>MAQ.</h5></td>
            <td align="center"><strong>Jueves</strong> | {{ \Carbon\Carbon::parse($planProduccion->fecha_emision)->addDays(3)->format('d-m-Y')}}</td>
            <td align="center" width="7"><h5>MAQ.</h5></td>
            <td align="center"><strong>Viernes</strong> | {{ \Carbon\Carbon::parse($planProduccion->fecha_emision)->addDays(4)->format('d-m-Y')}}</td>
            <td align="center" width="7"><h5>MAQ.</h5></td>
            <td align="center"><strong>Sábado</strong> | {{ \Carbon\Carbon::parse($planProduccion->fecha_emision)->addDays(5)->format('d-m-Y')}}</td>

          	</tr>

    </table>

    <table border="0" width="798">
    <tr>
      <td width="133" style="padding-left:-5px;">
    <table border="1" width="auto">
          @foreach ($planProduccionDetalleLunes as $monday)
            <tr>
              <td align="center"><strong>{{$monday->maquina}}</strong></td>
              <td>{{$monday->producto->descripcion}} <br> <strong>Cant.:</strong> {{$monday->cantidad}} | <strong>Destino:</strong> {{$monday->destino}}</td>
            </tr>
          @endforeach
      </table>
    </td>
      <td width="133" style="padding-left:-5px;">
      <table border="1" width="auto">
            @foreach ($planProduccionDetalleMartes as $tuesday)
              <tr>
                <td align="center"><strong>{{$tuesday->maquina}}</strong></td>
                <td>{{$tuesday->producto->descripcion}} <br> <strong>Cant.:</strong> {{$tuesday->cantidad}} | <strong>Destino:</strong> {{$tuesday->destino}}</td>
              </tr>
            @endforeach
          </table>
          </td>
          <td width="133" style="padding-left:-5px;">
        <table border="1" width="auto">

              @foreach ($planProduccionDetalleMiercoles as $wednesday)
                <tr>
                  <td align="center"><strong>{{$wednesday->maquina}}</strong></td>
                  <td>{{$wednesday->producto->descripcion}} <br> <strong>Cant.:</strong> {{$wednesday->cantidad}} | <strong>Destino:</strong> {{$wednesday->destino}}</td>
                </tr>
              @endforeach
          </table>
        </td>
        <td width="133" style="padding-left:-5px;">
      <table border="1" width="auto">
            @foreach ($planProduccionDetalleJueves as $thursday)
              <tr>
                <td align="center"><strong>{{$thursday->maquina}}</strong></td>
                <td>{{$thursday->producto->descripcion}} <br> <strong>Cant.:</strong> {{$thursday->cantidad}} | <strong>Destino:</strong> {{$thursday->destino}}</td>
              </tr>
            @endforeach
        </table>
      </td>
      <td width="133" style="padding-left:-5px;">
    <table border="1" width="auto">
          @foreach ($planProduccionDetalleViernes as $friday)
            <tr>
              <td align="center"><strong>{{$friday->maquina}}</strong></td>
              <td>{{$friday->producto->descripcion}} <br> <strong>Cant.:</strong> {{$friday->cantidad}} | <strong>Destino:</strong> {{$friday->destino}}</td>
            </tr>
          @endforeach
      </table>
    </td>
    <td width="133" style="padding-left:-5px;">
  <table border="1" width="auto">
        @foreach ($planProduccionDetalleSabado as $saturday)
          <tr>
            <td align="center"><strong>{{$saturday->maquina}}</strong></td>
            <td>{{$saturday->producto->descripcion}} <br> <strong>Cant.:</strong> {{$saturday->cantidad}} | <strong>Destino:</strong> {{$saturday->destino}}</td>
          </tr>
        @endforeach
    </table>
  </td>
            </tr>
        </table>

    </body>
</html>
