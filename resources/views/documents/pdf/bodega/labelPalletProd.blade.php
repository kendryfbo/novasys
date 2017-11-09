<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Novasys 2.0</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">

</head>
<body>
	<div class="contenedor">

        <div class="form-horizontal">

            <div class="form-group">

                <div class="col-sm-1 pull-right">
                    {!!$barCode!!}
                    {{$pallet->numero}}
                </div>

                <div class="col-sm-1">

                    <p><strong>CODIGO: </strong>{{$pallet->detalleGroup[0]->codigo}}</p>
                    <p><strong>PRODUCTO: </strong></p>
                    <p>{{$pallet->detalleGroup[0]->descripcion}}</p>
                    <p><strong>UNIDADES: </strong>{{$pallet->detalleGroup[0]->cantidad}}</p>

                </div>

            </div>

            <div class="form-group">

                <div class=" col-sm-5">

                    <table>
                            @foreach ($pallet->detalles as $detalle)
                                <tr>
                                    @if ($detalle->produccion)
                                        <td class="text-left"><strong>Lote:</strong> {{$detalle->produccion->lote}} </td>
                                    @else
                                        <td class="text-left"><strong>Lote:</strong> </td>
                                    @endif
                                    <td class="text-left"></td>
                                    <td class="text-left"><strong>/ Venc:</strong> {{$detalle->fecha_venc}}</td>
                                    <td class="text-left"><strong>/ Cant:</strong> {{$detalle->cantidad}}</td>
                                </tr>
                            @endforeach
                    </table>


                </div>

            </div>

        </div>

	</div>

    <script src="{{asset('js/customDataTable.js')}}"></script>
</body>
</html>
