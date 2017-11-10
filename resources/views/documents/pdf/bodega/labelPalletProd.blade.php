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

                    <p><strong> FECHA: </strong>{{$pallet->created_at}}</p>
                    <p><strong>NUMERO: </strong>{{$pallet->numero}}</p>
                    <p><strong>TOTAL: </strong>{{$pallet->detalles->sum('cantidad')}}</p>

                </div>

            </div>

            <div class="form-group">


                <table>
                        @foreach ($pallet->detalles as $detalle)
                            <tr>
                                <td class="text-left"><h6><strong>Producto:</strong>{{$detalle->producto->descripcion}}</h6></td>
                            </tr>
                            <tr>
                                <td class="text-left"><h6>
                                    <strong>Lote:</strong> {{$detalle->produccion ? $detalle->produccion->lote : ''}}
                                    <strong>Venc:</strong> {{$detalle->fecha_venc}}
                                    <strong>Cant:</strong> {{$detalle->cantidad}}</h6>
                                </td>
                            </tr>
                        @endforeach
                </table>

                <label class="col-sm-2 pull-right" for="">Total: {{$pallet->detalles->sum('cantidad')}}</label>

                <br>
                <br>

                <label class="col-sm-2 col-sm-offset-2" for="">C Calidad Envasado</label>
                <label class="col-sm-1" for="">C Calidad Bodega</label>

            </div>

        </div>

	</div>

    <script src="{{asset('js/customDataTable.js')}}"></script>
</body>
</html>
