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
                    <h2 class="text-center">LISTADO DE ORDENES DE COMPRA POR PRODUCTOS</h2>
                </th>
            </tr>
        </table>
        @foreach ($ordenes as $orden)
            <div class="page-break">
                <table class="table" width="80%">
                    <tbody>
                        <tr>
                            <td class="text-right"> <h3>RUT:</h3></td>
                            <th class="text-left"> <h3>{{$orden->proveedor->rut}}</h3></th>
                            <td class="text-right"> <h3>Proveedor: </h3></td>
                            <th class="text-left"> <h3>{{$orden->proveedor->descripcion}}</h3></th>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <table class="table" width="100%">
                    <tbody>

                        <tr>
                            <td class="text-right border-bottom">Orden Compra:</td>
                            <th class="text-left border-bottom">{{$orden->numero}}</th>
                            <td class="text-right border-bottom">F.Emision:</td>
                            <th class="text-left border-bottom">{{$orden->fecha_emision}}</th>
                            <td class="text-right border-bottom">Moneda:</td>
                            <th class="text-center border-bottom">{{$orden->moneda}}</th>
                        </tr>
                        <tr>
                            <th colspan="7" class="text-center">ARTICULOS</th>
                        </tr>
                        <tr>
                            <td> </td>
                            <th class="text-center border-bottom">Codigo</th>
                            <th style="width:300px" class="text-center border-bottom">Descripcion</th>
                            <th class="text-center border-bottom">Precio</th>
                            <th class="text-center border-bottom">cantidad</th>
                            <th class="text-center border-bottom">Sub.Total</th>
                        </tr>
                        @foreach ($orden->detalles as $detalle)
                        <tr>
                            <td> </td>
                            <td class="text-center">{{$detalle->codigo}}</td>
                            <td class="text-left">{{$detalle->descripcion}}</td>
                            <td class="text-right">{{number_format($detalle->precio,2)}}</td>
                            <td class="text-right">{{$detalle->cantidad}}</td>
                            <td class="text-right">{{number_format($detalle->sub_total,2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </body>
</html>
