<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Orden Egreso N°{{$ordenEgreso->numero}}</title>

        <!-- PDF default CSS -->
        <link rel="stylesheet" href="{{asset('css/bodega/ordenEgreso/formatoPDF.css')}}">
    </head>
    <body>
        <h1 class="text-center">Orden de Egreso Bodega</h1>

        <div class="title-content">
            <h3 class="num-oc">
                Nº{{$ordenEgreso->numero}}
            </h3>
            <h4 class="date">
                Santiago, {{$ordenEgreso->fecha_gen}}
            </h4>
            <table>
                <tr>
                    <td>Orden de Egreso N°: <strong>{{$ordenEgreso->numero}}</strong></td>
                </tr>
                <tr>
                    <td>Documento: <strong>{{$ordenEgreso->tipo_descrip}}</strong></td>
                </tr>
                <tr>
                    <td>Cliente: <strong>{{$ordenEgreso->documento->cliente->descripcion}}</strong></td>
                </tr>
            </table>
        </div>

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
                    @foreach ($ordenEgreso->detalles as $detalle)
                        <tr>
                            <td class="text-left">{{$detalle->bodega}}</td>
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
                    <th class="text-right">{{$ordenEgreso->detalles->sum('cantidad')}}</th>
                </tr>
            </tbody>
        </table>
    </body>
</html>
