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
            @foreach ($ordenesCompra->sortBy('proveedor.descripcion') as $orden)
            <div class="page-break">
            <table class="table" width="100%">
                <tbody>
                    <tr>
                        <td class="text-right border-bottom">Proveedor:</td>
                        <th colspan="4" class="text-left border-bottom">{{$orden->proveedor->descripcion}}</th>
                        <th class="text-center border-bottom">Moneda</th>
                        <th class="text-center border-bottom">Desc.</th>
                        <th class="text-center border-bottom">Neto</th>
                        <th class="text-center border-bottom">Impuesto</th>
                        <th class="text-center border-bottom">Total</th>
                    </tr>
                    <tr>
                        <td> </td>
                        <td class="text-right border-bottom">O.C.:</td>
                        <th class="text-left border-bottom">{{$orden->numero}}</th>
                        <td class="text-right border-bottom">F.Emision:</td>
                        <th class="text-left border-bottom">{{$orden->fecha_emision}}</th>
                        <td class="text-center border-bottom">{{$orden->moneda}}</td>
                        <td class="text-right border-bottom">{{$orden->descuento}}</td>
                        <td class="text-right border-bottom">{{$orden->neto}}</td>
                        <td class="text-right border-bottom">{{$orden->impuesto}}</td>
                        <td class="text-right border-bottom">{{$orden->total}}</td>
                    </tr>
                    <tr>
                        <td> </td>
                        <th colspan="9" class="text-center">ARTICULOS</th>
                    </tr>
                    <tr>
                        <td> </td>
                        <th class="text-center border-bottom">Codigo</th>
                        <th colspan="5" class="text-center border-bottom">Descripcion</th>
                        <th class="text-center border-bottom">Cantidad</th>
                        <th class="text-center border-bottom">Recibidos</th>
                        <th class="text-center border-bottom">Pendientes</th>
                    </tr>
                        @foreach ($orden->detalles as $detalle)
                        <tr>
                            <td> </td>
                            <td class="text-center">{{$detalle->codigo}}</td>
                            <td colspan="5">{{$detalle->descripcion}}</td>
                            <td class="text-right">{{$detalle->cantidad}}</td>
                            <td class="text-right">{{$detalle->recibidas}}</td>
                            <td class="text-right">{{$detalle->cantidad - $detalle->recibidas}}</td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
            </div>
            <br>
        @endforeach
    </body>
</html>
