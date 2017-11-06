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

                <div class="col-lg-1 pull-right">

                    {!!$barCode!!}
                    {{$pallet->numero}}

                </div>

                <div class="col-lg-2">

                    @foreach ($pallet->detalles as $detalle)
                        <h6>Fecha: <strong>{{$detalle->created_at}}</strong></h6>
                        <h6>Codigo: <strong>{{$detalle->codigo}}</strong></h6>
                        <h6>Producto: <strong>{{$detalle->descripcion}}</strong></h6>
                        <h6>Cantidad: <strong>{{$detalle->cantidad}}</strong></h6>
                    @endforeach

                </div>



            </div>

        </div>


        <div class="col-lg-offset-1 col-lg-2">
            @foreach ($pallet->detalles as $detalle)
                <h6>lote: <strong>{{$detalle->lote}}</strong></h6>
            @endforeach

        </div>

	</div>

</body>
</html>
