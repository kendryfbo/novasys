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
      margin-left: : 10px;
    }
    .contenedor {
      padding-left: 10px;
    }
    .heading {
      height: 110px;
    }
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

        <h5>{{$factura->centro_venta}}</h5>
        <h5>{{$factura->cliente}}</h5>
        <h5> <strong>Factura N° / Invoice N°: </strong>{{$factura->numero}}</h5>
        <h5><strong>Contenedor N° / Container N°: </strong>{{$guia->contenedor}}</h5>
        <h5 class="etiqueta">PACKING LIST</h5>
      </div>
      <div class="body">

        <table class="table table-custom table-bordered table-condensed">

          <thead>

            <tr>
              <th class="text-center">#</th>
              <th class="text-center">CANTIDAD / QTTY</th>
              <th class="text-center">CODIGO / CODE</th>
              <th class="text-center">DESCRIPCION / DESCRIPTION</th>
              <th class="text-center">FORMATO / FORMAT</th>
              <th class="text-center">PESO NETO / NET WEIGHT</th>
              <th class="text-center">PESO BRUTO / GROSS WEIGHT</th>
              <th class="text-center">VOLUMEN / VOLUME</th>
            </tr>

          </thead>

          <tbody>

            @foreach ($guia->detalles as $detalle)
              <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td class="text-right">{{$detalle->cantidad}}</td>
                <td class="text-center">{{$detalle->producto->codigo}}</td>
                <td>{{$detalle->producto->marca->descripcion . " "}}
                {{$detalle->producto->formato->descripcion . " "}}
                @if ($factura->clienteIntl->idioma == 'Ingles')
                {{$detalle->producto->sabor->descrip_ing}}
                @else
                {{$detalle->producto->sabor->descripcion}}
                @endif</td>
                <td>{{$detalle->producto->formato->descripcion}}</td>
                <td class="text-right">{{number_format($detalle->cantidad * $detalle->producto->peso_neto,2)}}</td>
                <td class="text-right">{{number_format($detalle->cantidad * $detalle->producto->peso_bruto,2)}}</td>
                <td class="text-right">{{number_format($detalle->cantidad * $detalle->producto->volumen,2)}}</td>
              </tr>
            @endforeach

              <tr>
                <td></td>
                <th class="text-right">{{$guia->detalles->sum('cantidad')}}</th>
                <th class="text-right" colspan="3">TOTALES :</th>
                <td class="text-right">{{number_format($guia->peso_neto_total,2,',','.')}}</td>
                <td class="text-right">{{number_format($guia->peso_bruto_total,2,',','.')}}</td>
                <td class="text-right">{{number_format($guia->volumen_total,2,',','.')}}</td>
              </tr>

          </tbody>

        </table>

      </div>

    </div>

  </body>

</html>
