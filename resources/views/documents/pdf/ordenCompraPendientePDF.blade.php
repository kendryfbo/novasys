<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Orden Compra Pendientes</title>

        <!-- PDF default CSS -->
        <link rel="stylesheet" href="{{asset('css/adquisicion/ordenCompra/ordenCompraPendientePDF.css')}}">
    </head>
    <body>

        <table class="title-content" width="100%">
            <tr>
                <th>
                    <h2 class="text-center">LISTADO DE ORDENES DE COMPRA CON SALDOS PENDIENTES</h2>
                </th>
            </tr>
        </table>
        <br>
            @foreach ($proveedores as $proveedor)

            <table class="table" width="100%">
                <tbody>
                    <tr>
                        <td class="text-right border-bottom">Proveedor:</td>
                        <th colspan="5" class="text-left border-bottom">{{$proveedor->descripcion}}</th>
                        <th class="text-center border-bottom">Moneda</th>
                        <th class="text-center border-bottom">Desc.</th>
                        <th class="text-center border-bottom">Neto</th>
                        <th class="text-center border-bottom">Impuesto</th>
                        <th class="text-center border-bottom">Total</th>
                    </tr>
                    @foreach ($proveedor->ordenCompras as $orden)
                    <tr>
                        <td> </td>
                        <td class="text-right border-bottom">O.C.:</td>
                        <th class="text-left border-bottom">{{$orden->numero}}</th>
                        <td class="text-right border-bottom">F.Emision:</td>
                        <th colspan="2" class="text-left border-bottom">{{date("d-m-Y", strtotime($orden->fecha_emision))}}</th>
                        <td class="text-center border-bottom">{{$orden->moneda}}</td>
                        <td class="text-right border-bottom">{{number_format($orden->descuento,2)}}</td>
                        <td class="text-right border-bottom">{{number_format($orden->neto,2)}}</td>
                        <td class="text-right border-bottom">{{number_format($orden->impuesto,2)}}</td>
                        <td class="text-right border-bottom">{{number_format($orden->total,2)}}</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <th colspan="9" class="text-center">ARTICULOS</th>
                    </tr>
                    <tr>
                        <td colspan="2"> </td>
                        <th class="text-center border-bottom">Codigo</th>
                        <th colspan="5" class="text-center border-bottom">Descripcion</th>
                        <th class="text-center border-bottom">Cantidad</th>
                        <th class="text-center border-bottom">Recibidos</th>
                        <th class="text-center border-bottom">Pendientes</th>
                    </tr>
                        @foreach ($orden->detalles as $detalle)
                        @if ($detalle->recibidas < $detalle->cantidad)
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-center">{{$detalle->codigo}}</td>
                            <td colspan="5">{{$detalle->descripcion}}</td>
                            <td class="text-right">{{number_format($detalle->cantidad,2)}}</td>
                            <td class="text-right">{{number_format($detalle->recibidas,2)}}</td>
                            <td class="text-right">{{number_format($detalle->cantidad - $detalle->recibidas,2)}}</td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <th colspan="9" class="text-center">-</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </body>
</html>
