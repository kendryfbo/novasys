<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <title>Pallet</title>
 <!-- Tell the browser to be responsive to screen width -->
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <!-- PDF default CSS -->
 <link rel="stylesheet" href="{{asset('css/bodega/pallet/formatoPalletPDF.css')}}">

 <style>

 </style>

</head>
<body>
    <table class="table" width="100%">

  <tr>
      <td class="text-right">FECHA:</td>
    <td class="text-center">{{$pallet->fecha}}</td>
    <td colspan="4" rowspan="2" style="padding-left:80px"> {!!$barCode!!}</td>
  </tr>
  <tr>
      <td class="text-right">PALLET N°:</td>
      <td class="text-center">{{$pallet->numero}}</td>
  </tr>
  <tr>
    <td class="text-right">P.FISICO N°:</td>
    <td class="text-center">{{$pallet->numero}}</td>
    <td colspan="4" class="text-center">{{$pallet->numero}}</td>
  </tr>

  <tr>
      <th class="text-center" >CODIGO</th>
      <th class="text-center" colspan="3">DESCRIPCION</th>
      <th class="text-center" >LOTE N°</th>
      <th class="text-center" >CANT</th>
  </tr>
  @foreach ($pallet->detalles as $detalle)
      <tr>
          <td>{{$detalle->producto->codigo}}</td>
          <td colspan="3">{{$detalle->producto->descripcion}}</td>
          <td class="text-center">{{$detalle->ingreso->detalles[0]->lote}}</td>
          <td class="text-right">{{$detalle->cantidad}}</td>
      </tr>

  @endforeach
  <tr>
      <th colspan="5" class="text-right">TOTAL:</th>
      <th class="text-right">{{$pallet->detalles->sum('cantidad')}}</th>
  </tr>
  <tr>
      <td class="text-center" colspan="3" style="height:30px;"></td>
      <td class="text-center" colspan="3" style="height:30px;"></td>
  </tr>
  <tr>
      <td class="text-center" colspan="3">C Calidad Envasado</td>
      <td class="text-center" colspan="3">C Calidad Bodega</td>
  </tr>


</table>

<script src="{{asset('js/customDataTable.js')}}"></script>
</body>
</html>
