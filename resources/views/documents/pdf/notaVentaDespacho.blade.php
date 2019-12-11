<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>PROFORMA N°{{$notaVenta->numero}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- PDF default CSS -->
        <link rel="stylesheet" href="{{asset('css/comercial/notaVenta/formatoPDF.css')}}">
    </head>
    <body>
        <div class="title-content">

            <h2 class="descrip-cv"><strong>{{$notaVenta->centroVenta->descripcion}}</strong></h2>
            <p class="giro-cv"><strong>{{$notaVenta->centroVenta->giro}}</strong></p>
            <p class="giro-cv"><strong>{{$notaVenta->centroVenta->direccion}}</strong></p>
            <p class="giro-cv"><strong>Fono: {{$notaVenta->centroVenta->fono}}</strong></p>
            <p class="giro-cv"><strong>SANTIAGO - CHILE</p>

            <H2 class="num-proforma"><strong>NOTA VENTA N° {{$notaVenta->numero}}</strong></H2>
            <h3 class="ver-proforma"><strong>VERSION N° {{$notaVenta->version}}</strong></h3>
        </div>

        <div class="cliente-content">
            <div class="cliente-datos">
                <table>
                  <tbody>
                      <tr>
                          <td class="text-right">CLIENTE :</td>
                          <th>{{$notaVenta->cliente->descripcion}}</th>
                      </tr>
                      <tr>
                          <td class="text-right">DIRECCION :</td>
                          <th>{{$notaVenta->cliente->direccion}}</th>
                      </tr>
                      <tr>
                          <td class="text-right">RUT :</td>
                          <th>{{strtoupper($notaVenta->cliente->rut)}}</th>
                      </tr>
                      <tr>
                          <td class="text-right">CONTACTO :</td>
                          <th>{{strtoupper($notaVenta->cliente->contacto)}}</th>
                      </tr>
                      <tr>
                          <td class="text-right">DESPACHO :</td>
                          <th>{{strtoupper($notaVenta->despacho)}}</th>
                      </tr>
                      <tr>
                          <td class="text-right">O.C :</td>
                          <th>{{strtoupper($notaVenta->orden_compra)}}</th>
                      </tr>
                  </tbody>
                </table>
            </div>
            <div class="fecha">
                <p>FECHA/DATE : <strong>{{$notaVenta->fecha_emision}}</strong></p>
            </div>
            <div style="clear:both"></div>
        </div>

        <div class="table-content">
            <table class="table" width="auto">
                <col >
                <thead>
                    <tr>
                        <th style="width:10">#</th>
                        <th style="width:70">CODIGO</th>
                        <th style="width:243">PRODUCTO</th>
                        <th style="width:30">CANT</th>
                        <th style="width:50">PRECIO</th>
                        <th style="width:70">TOTAL</th>
                        <th style="width:27">DESC.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notaVenta->detalles as $detalle)
                        <tr>
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td class="text-left">{{$detalle->codigo}}</td>
                            <td class="text-left">{{$detalle->descripcion}}</td>
                            <td class="text-right">{{$detalle->cantidad}}</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <table class="table table-pesos" width="400px">
            <thead>
                <tr>
                    <th style="width:80px">TOTAL CAJAS</th>
                    <th style="width:80px">TOTAL BRUTO</th>
                    <th style="width:80px">TOTAL NETO</th>
                    <th style="width:60px">VOLUMEN</th>
                </tr>
                <tr>
                    <th class="text-right">{{number_format($notaVenta->detalles->sum('cantidad'))}}</th>
                    <th class="text-right">{{number_format($notaVenta->peso_bruto,2)}}</th>
                    <th class="text-right">{{number_format($notaVenta->peso_neto,2)}}</th>
                    <th class="text-right">{{number_format($notaVenta->volumen,2)}}</th>
                </tr>
            </thead>
        </table>

    </body>
</html>
