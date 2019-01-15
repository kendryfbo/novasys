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
            margin-bottom: : 10px;
            margin-top: 10px;
            padding: 0px;
            height: 620px;
        }
        .datos > .tabla {
            width: 100%;
        }
        .datos > .tabla > tbody {
            font-size: 10px;
        }


        .final {
            font-size: 12px;
            position: relative;
            border: 1px solid black;
            margin: 0px;
            padding: 0px;
            height: 110px;
        }
        .final > .footer {
            margin: 5px;
        }
        .final > .total {
            position: absolute;
            top: 5px;
            width:200px;
            right: 0px;
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
                        <th class="text-center">#</th>
                        <th class="text-center">CODIGO</th>
                        <th>PRODUCTO</th>
                        <th class="text-center">CANTIDAD</th>
                        <th class="text-right">PRECIO</th>
                        <th class="text-right">TOTAL</th>
                        <th class="text-center">DESC.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notaVenta->detalle as $detalle)
                        <tr>
                            <th class="text-center">{{$loop->iteration}}</th>
                            <td class="text-center">{{$detalle->producto_id}}</td>
                            <td>{{$detalle->descripcion}}</td>
                            <td class="text-center">{{$detalle->cantidad}}</td>
                            <td class="text-right">{{-- $detalle->precio --}}</td>
                            <td class="text-right">{{-- $detalle->sub_total --}}</td>
                            <td class="text-center">{{-- $detalle->descuento --}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="final">
            <div class="footer">
                <table>
                    <tr>
                        <th class="text-right">CONDICION DE PAGO : </th>
                        <td class="text-left"><strong>{{--$notaVenta->formaPago->descripcion--}}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-right">TOTALES CAJAS : </th>
                        <td class="text-left"><strong>{{$notaVenta->detalle->sum('cantidad')}}</strong></td>
                    </tr>
                </table>
            </div>
            <div class="total">
                {{-- <table>
                    <tr>
                        <th class="text-right">SUB-TOTAL : </th>
                        <td class="text-right"><strong>{{$notaVenta->sub_total}}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-right">DESC. : </th>
                        <td class="text-right"><strong>{{$notaVenta->descuento}}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-right">NETO : </th>
                        <td class="text-right"><strong>{{$notaVenta->neto}}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-right">I.V.A : </th>
                        <td class="text-right"><strong>{{$notaVenta->iva}}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-right">I.A.B.A : </th>
                        <td class="text-right"><strong>{{$notaVenta->iaba}}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-right">TOTAL : </th>
                        <td class="text-right"><strong>{{$notaVenta->total}}</strong></td>
                    </tr>
                </table> --}}
            </div>

        </div>
	</div>

</body>
</html>
