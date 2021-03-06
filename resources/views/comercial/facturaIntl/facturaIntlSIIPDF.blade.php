<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Factura Intl N°{{$factura->numero}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- PDF default CSS -->
        <link rel="stylesheet" href="{{asset('css/comercial/facturaIntl/formatoSIIPDF.css')}}">
    </head>
    <body>
        <div class="cliente-descripcion">
            <h3>{{$factura->cliente}}<br>
                {{strtoupper($factura->direccion)}}<br>
                {{strtoupper($factura->clienteIntl->pais->nombre)}}</h3>
        </div>
        <div class="text-center marcas">
            <h3></h3>
        </div>
        <div class="text-center numero">
            <h2>{{$factura->numero}}</h2>
        </div>
        <div class="text-center fecha">
         <h3>{{$factura->day}} &nbsp; {{$factura->month}} &nbsp; {{$factura->year}}</h3>
        </div>

        <div class="text-center medio-transporte">
            <h3>{{strtoupper($factura->transporte)}}</h3>
        </div>
        <div class="text-center puerto-embarque">
            <h3>{{strtoupper($factura->puerto_emb)}}</h3>
        </div>
        <div class="text-right forma-pago">
            <h3>{{strtoupper($factura->forma_pago)}}</h3>
        </div>
        <div class="text-right cond-venta">
            <h3>{{strtoupper($factura->clau_venta)}}</h3>
        </div>
        <div class="text-center puerto-destino">
            <h3>{{strtoupper($factura->puerto_dest)}}</h3>
        </div>
        <table class="lista-productos" width="95%">
            <tbody>
                @foreach ($factura->detalles as $detalle)
                    <tr>
                        <td width="70px"><strong>{{$detalle->cantidad}}</strong></td>
                        <td width="340px">
                            <strong>
            {{$detalle->producto->marca->descripcion . " " .$detalle->producto->formato->descripcion}}
            @if ($factura->clienteIntl->idioma == 'Ingles')
            {{$detalle->producto->sabor->descrip_ing}}
            @else
            {{$detalle->producto->sabor->descripcion}}
            @endif

                            </strong>
                        </td>
                        <td width="130px" class="text-right"><strong>{{number_format($detalle->precio,2)}}</strong></td>
                        <td width="130px" class="text-right"><strong>{{number_format($detalle->sub_total,2)}}</strong></td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4"> </td>
                </tr>
                @if ($factura->fob)
                    <tr>
                        <td class="text-right" colspan="3"><strong> TOTAL F.O.B : </strong></td>
                        <td class="text-right"><strong>{{number_format($factura->fob,2)}}</strong></td>
                    </tr>
                @endif
                @if ($factura->freight)
                    <tr>
                        <td class="text-right" colspan="3"><strong> FREIGHT : </strong></td>
                        <td class="text-right"><strong>{{number_format($factura->freight,2)}}</strong></td>
                    </tr>
                @endif
                @if ($factura->insurance)
                    <tr>
                        <td class="text-right" colspan="3"><strong> INSURANCE : </strong></td>
                        <td class="text-right"><strong>{{number_format($factura->insurance,2)}}</strong></td>
                    </tr>
                @endif
                @if ($factura->cif)
                    <tr>
                        <td class="text-right" colspan="3"><strong> TOTAL C.I.F : </strong></td>
                        <td class="text-right"><strong>{{number_format($factura->cif,2)}}</strong></td>
                    </tr>
                @endif
            </tbody>
        </table>

    </body>
</html>
