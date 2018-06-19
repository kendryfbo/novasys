<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Orden Egreso N°{{$egreso->numero}}</title>

        <!-- PDF default CSS -->
        <link rel="stylesheet" href="{{asset('css/bodega/egreso/formatoPDF.css')}}">
    </head>
    <body>
        <h1 class="text-center">Orden de Egreso Bodega</h1>

        <div class="title-content">
            <h3 class="num-oc">
                Nº {{$egreso->numero}}
            </h3>
            <h4 class="date">
                Fecha Generacion :
                Santiago, {{$egreso->fecha_egr}}
            </h4>
            <h4 class="date2">
                Fecha Despacho :
            </h4>
            <table>
                <tr>
                    <td >Orden de Egreso N°: <strong>{{$egreso->numero}}</strong></td>
                </tr>
                <tr>
                    <td >Tipo Egreso: <strong>{{$egreso->tipo->descripcion}}</strong></td>
                </tr>
                <tr>
                    <td >Descripcion: <strong>{{$egreso->descripcion}}</strong></td>
                </tr>
                @if (!is_null($egreso->documento))
                    <tr>
                        <td >Cliente: <strong>{{$egreso->documento->cliente->descripcion}}</strong></td>
                    </tr>
                @endif
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
                    @foreach ($egreso->detalles as $detalle)
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
                    <th class="text-right">{{$egreso->detalles->sum('cantidad')}}</th>
                </tr>
            </tbody>
        </table>
    </body>
</html>
