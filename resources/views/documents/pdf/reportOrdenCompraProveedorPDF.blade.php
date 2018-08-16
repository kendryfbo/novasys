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
                    <h2 class="text-center">LISTADO DE ORDENES DE COMPRA POR PROVEEDOR</h2>
                </th>
            </tr>
        </table>
        <br>
        <div>
            <table class="table" width="60%">
                <tbody>
                    <tr>
                        <td class="text-right">RUT:</td>
                        <th class="text-left">{{$proveedor->rut}}</th>
                        <td class="text-right">Proveedor:</td>
                        <th class="text-left">{{$proveedor->descripcion}}</th>
                    </tr>
                </tbody>
            </table>
            <hr>
            <table class="table" width="100%">
                <tbody>
                    <tr>
                        <th class="text-center border-bottom">Numero</th>
                        <th class="text-center border-bottom">F.Emision</th>
                        <th class="text-center border-bottom">MONEDA</th>
                        <th class="text-center border-bottom">DESC.</th>
                        <th class="text-center border-bottom">NETO</th>
                        <th class="text-center border-bottom">IMP.</th>
                        <th class="text-center border-bottom">TOTAL</th>
                    </tr>
                    @foreach ($ordenes as $orden)
                    <tr>
                        <td class="text-center">{{$orden->numero}}</td>
                        <td class="text-center">{{$orden->fecha_emision}}</td>
                        <td class="text-center">{{$orden->moneda}}</td>
                        <td class="text-right">{{number_format($orden->descuento,2)}}</td>
                        <td class="text-right">{{number_format($orden->neto,2)}}</td>
                        <td class="text-right">{{number_format($orden->impuesto,2)}}</td>
                        <td class="text-right">{{number_format($orden->total,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
        </div>
    </body>
</html>
