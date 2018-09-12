<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Packing List</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">

    <style>
    body {
      font-size: 10px;
    }
    .contenedor {
      padding-left: 15px;
    }
    .heading {

      height: 150px;
    };
    .table-bordered {
      border: 1px solid black;
    }
    .table-bordered > thead > tr > th,
    .table-bordered > tbody > tr > th,
    .table-bordered > tfoot > tr > th,
    .table-bordered > thead > tr > td,
    .table-bordered > tbody > tr > td,
    .table-bordered > tfoot > tr > td {
      padding: 2px;
      border: 1px solid black;
    }
    .table-bordered > thead > tr > th,
    .table-bordered > thead > tr > td {
      padding: 2px;
      border-bottom-width: 2px;
    }
    .etiqueta {
      position: absolute;
      right: 50px;
      top: 30px;
    }
    </style>

  </head>


  <body>

    <div class="contenedor">

      <div class="heading">

        <h4>{{$factura->centro_venta}}</h3>
        <h4>{{$factura->cliente}}</h3>
        <h4> <strong>Factura N°</strong>{{$factura->numero}}</h3>
        <h4><strong>Contenedor N°</strong>{{$guia->contenedor}}</h3>
        <h5 class="etiqueta">PACKING LIST</h4>
      </div>
      <div class="body">

        <table class="table table-custom table-bordered table-condensed">

          <thead>

            <tr>
              <th>#</th>
              <th>CANTIDAD</th>
              <th>CODIGO</th>
              <th>DESCRIPCION</th>
              <th>FORMATO</th>
              <th>PESO NETO</th>
              <th>PESO BRUTO</th>
              <th>VOLUMEN</th>
            </tr>

          </thead>

          <tbody>

            @foreach ($guia->detalles as $detalle)

              <tr>
                <td>{{$loop->iteration}}</td>
                <td class="text-right">{{$detalle->cantidad}}</td>
                <td>{{$detalle->producto->codigo}}</td>
                <td>{{$detalle->producto->descripcion}}</td>
                <td>{{$detalle->producto->formato->descripcion}}</td>
                <td class="text-right">{{$detalle->producto->peso_neto}}</td>
                <td class="text-right">{{$detalle->producto->peso_bruto}}</td>
                <td class="text-right">{{$detalle->producto->volumen}}</td>
              </tr>

            @endforeach

              <tr>
                <td></td>
                <th class="text-right">{{$guia->detalles->sum('cantidad')}}</th>
                <th colspan="3">TOTALES</th>
                <td class="text-right">{{$guia->detalles->sum('producto.peso_neto')}}</td>
                <td class="text-right">{{$guia->detalles->sum('producto.peso_bruto')}}</td>
                <td class="text-right">{{$guia->detalles->sum('producto.volumen')}}</td>
              </tr>

          </tbody>

        </table>

      </div>

    </div>

  </body>

</html>
