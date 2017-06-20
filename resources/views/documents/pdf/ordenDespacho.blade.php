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

	<style>
        @page {
            margin: 0px;
            margin-top: 40px;
        }
        h3,h4,h5 {
            margin: 0px;
            padding: 0px;
        }
        p {
            font-size: 12px;
            white-space: pre-wrap;
            margin: 0px;
            padding: 0px;
        }

        .contenedor {
            margin: 0px 30px 0px 30px;
        }
        .titulo {
            position: relative;
            margin: 50px 0px 10px 0px;
            padding: 0px;
        }

        .titulo > .numero {

            position: absolute;
            right: 50px;
            top: 40px;
        }

        .cliente {
            position: relative;
            border: 1px solid black;
            margin: 0px;
            padding: 1px;
        }

        .cliente > .fono {
            white-space: pre-wrap;
            position: absolute;
            right: 30px;
            top: 0px;
            margin: 0px;
            padding: 0px;
        }
        .cliente > .fecha {
            white-space: pre-wrap;
            position: absolute;
            right: 30px;
            top: 25px;
            margin: 0px;
            padding: 0px;
        }

        .datos {
            position: relative;
            border: 1px solid black;
            margin: 0px;
            margin-top: 10px;
            padding: 0px;
            height: 630px;
        }
        .datos > .tabla {
            width: 100%;
        }
        .datos > .tabla > tbody {
            font-size: 10px;
        }


        .final {
            position: relative;
            border: 1px solid black;
            margin: 0px;
            padding: 0px;
        }

        .final > .total-right {
            width:250px;
            right: 10px;
        }

	</style>
</head>
<body>
	<div class="contenedor">
		<div class="titulo">
				<h3>{{$notaVenta->centroVenta->descripcion}}</h3>
				<h5>{{$notaVenta->centroVenta->giro}}</h5>
				<h5>{{$notaVenta->centroVenta->direccion}}</h5>
				<h5>{{$notaVenta->centroVenta->fono}}</h5>
                <h4 class="numero">Nota Venta Nº <strong>{{$notaVenta->numero}}</strong></h4>
		</div>

        <div class="cliente">

            <p>Cliente        : <strong>{{$notaVenta->cliente->descripcion}}</strong> </p>
            <p>Direccion    : <strong>{{$notaVenta->cliente->direccion}}</strong></p>
            <p>Ciudad       : <strong>{{$notaVenta->cliente->region->descripcion}}</strong></p>
            <p>Rut             : <strong>{{$notaVenta->cliente->rut}}</strong></p>
            <p>contacto     : <strong>{{$notaVenta->cliente->contacto}}</strong></p>
            <p class="fono">Fono  : <strong>{{$notaVenta->cliente->fono}}</strong></p>
            <p class="fecha">Fecha : <strong>{{$notaVenta->fecha_emision}}</strong></p>
        </div>

        <div class="datos">
            <table class="tabla">
                <thead>
                    <tr>
                        <th class="text-center">CODIGO</th>
                        <th>PRODUCTO</th>
                        <th class="text-center">CANTIDAD</th>
                        <th class="text-center">PRECIO</th>
                        <th class="text-center">TOTAL</th>
                        <th class="text-center">DESC.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notaVenta->detalle as $detalle)
                        <tr>
                            <td class="text-center">{{$detalle->producto_id}}</td>
                            <td>{{$detalle->descripcion}}</td>
                            <td class="text-center">{{$detalle->cantidad}}</td>
                            <td class="text-center">{{$detalle->precio}}</td>
                            <td class="text-center">{{$detalle->sub_total}}</td>
                            <td class="text-center">{{$detalle->descuento}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="final">
            <div class="total-right">
                <p>SUBTOTAL : <strong>{{$notaVenta->sub_total}}</strong></p>
                <p>DESC. : <strong>{{$notaVenta->descuento}}</strong></p>
                <p>NETO : <strong>{{$notaVenta->neto}}</strong></p>
                <p>I.V.A : <strong>{{$notaVenta->iva}}</strong></p>
                <p>I.A.B.A : <strong>{{$notaVenta->iaba}}</strong></p>
                <p>TOTAL : <strong>{{$notaVenta->total}}</strong></p>
            </div>

        </div>
		{{-- <div class="row cliente">
			<div class="col-xs-5">
				<h2>DATOS CLIENTE 1</h2>
			</div>
			<div class="col-xs-5">
				<h2>DATOS CLIENTE 2</h2>
			</div>
		</div> --}}
		{{-- <div class="row tabla">
			<div class="col-xs-12">
				<table class="table table-bordered table-custom" cellspacing="0" width="100%">

					<thead>
						<tr>
							<th>CODIGO</th>
							<th>DESCRIPCION</th>
							<th>CANTIDAD</th>
							<th>PRECIO</th>
							<th>TOTAL</th>
							<th>DESC.</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>#########</td>
							<td>#########</td>
							<td>#########</td>
							<td>#########</td>
							<td>#########</td>
							<td>#########</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row footer">
			<div class="col-xs-5">
				<h2>DATOS FOOTER 1</h2>
			</div>
			<div class="col-xs-5">
				<h2>DATOS FOOTER 2</h2>
			</div>
		</div> --}}

	</div>

</body>
</html>