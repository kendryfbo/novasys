<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Orden Egreso N°{{$egreso->numero}}</title>
        <!-- PDF default CSS -->
        <link rel="stylesheet" href="{{asset('css/bodega/egreso/formatoPDF.css')}}">
    </head>
    <body>

        <table class="title-content" width="100%">
            <tr>
                <th style="width:130px">
                </th>
                <th style="width:400px">
                    <h2 class="text-center">Orden de Egreso Bodega</h2>
                </th>
                <th class="text-center">
                </th>
            </tr>
        </table>

        <div class="title-content">
            <h3 class="num-oc">
                Nº {{$egreso->numero}}
            </h3>
            <table width="100%">
                <tr>
                    <td class="text-right" style="width: 70px">Despacho N°: </td>
                    <td class="text-left" colspan="3"><strong>{{$egreso->numero}}</strong></td>
                </tr>
                <tr>
                    <td class="text-right">Tipo Egreso:</td>
                    <td class="text-left" colspan="3"><strong>{{$egreso->tipo->descripcion}}</strong></td>
                </tr>
                <tr>
                    <td class="text-right">Descripcion:</td>
                    <td class="text-left" style="width:300px"><strong>{{$egreso->descripcion}}</strong></td>
                    <td class="text-right"><strong>Fecha Generacion:</strong></td>
                    <td class="text-left"><strong>Santiago, {{$egreso->fecha_egr}}</strong></td>
                </tr>
                <tr>
                    <td class="text-right">Cliente:</td>
                @if (!is_null($egreso->documento))
                    <td class="text-left"><strong>{{$egreso->documento->cliente->descripcion}}</strong></td>
                @else
                    <td class="text-left"></td>
                @endif
                <td class="text-right"><strong>Fecha Despacho:</strong></td>
                <td class="text-left"><strong>___________________</strong></td>
                </tr>
            </table>
        </div>
        <br>
        <div class="content">
            <table class="table" width="100%">
                <<thead>
                    <tr>
                        <th class="text-center">BODEGA</th>
                        <th class="text-center">POS</th>
                        <th class="text-center">DESCRIPCION</th>
                        <th class="text-center">CANT</th>
                        <th class="text-center">CARGA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($egreso->detalles as $detalle)
                        <tr>
                            <td class="text-center">{{$detalle->bodega}}</td>
                            <td class="text-center">{{$detalle->posicion}}</td>
                            <td class="text-left">{{$detalle->item->descripcion}}</td>
                            <td class="text-right">{{$detalle->cantidad}}</td>
                            <td class="text-right"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <table class="table table-total" width="200px">
            <tbody>
                <tr>
                    <th>TOTAL</th>
                    <th class="text-right">{{$egreso->detalles->sum('cantidad')}}</th>
                </tr>
            </tbody>
        </table>
    </body>
</html>
