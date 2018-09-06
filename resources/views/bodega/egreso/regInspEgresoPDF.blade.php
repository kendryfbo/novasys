<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Orden Egreso N°{{$egreso->numero}}</title>

        <!-- PDF default CSS -->
        <link rel="stylesheet" href="{{asset('css/bodega/egreso/formatoregInspEgresoPDF.css')}}">
    </head>
    <body>

        <table class="title-content" width="100%">
            <tr>
                <th style="width:130px">
                </th>
                <th style="width:400px">
                    <h2 class="text-center">REGISTRO DE INSPECCION DE PRODUCTOS TERMINADOS PARA DESPACHO</h2>
                </th>
                <th class="text-center">
                    FORM-407-13 Rev. 6
                </th>
            </tr>
        </table>

        <br>

        <div class="title-content">
            <table class="table-head" width="100%">
                <tr>
                    <th class="text-right">
                        CLIENTE :
                    </th>
                    <th class="text-left" colspan="3">
                        @if ($egreso->documento)
                            {{$egreso->documento->cliente->descripcion}}
                        @endif
                    </th>
                    <th class="text-right">
                        N° ORDEN :
                    </th>
                    <th class="text-left">
                        {{$egreso->numero}}
                    </th>
                </tr>
                <tr>
                    <th class="text-right">FECHA :</th>
                    <th class="text-left"> ____________ </th>
                    <th class="text-right">PRODUCTO :</th>
                    <th class="text-left"> ________________________________________________ </th>
                    <th class="text-right">PAIS :</th>
                    <th class="text-left"> ______________ </th>
                </tr>
                <tr>
                    <th class="text-right">PROFORMA :</th>
                    <th class="text-left"> ____________ </th>
                    <th class="text-right">FORMATO :</th>
                    <th class="text-left"> ________________________________________________ </th>
                    <th class="text-right">CANTIDAD :</th>
                    <th class="text-left"> {{$egreso->detalles->sum('cantidad')}}</th>
                </tr>
            </table>
        </div>
        <div class="title-content">

            <table class="table-head" width="100%">
                <tr>
                    <th class="text-center" colspan="8">VERIFICACÍON DEL ESTADO DEL CONTENEDOR</th>
                </tr>
                <tr>
                    <th class="text-left">MARCA:</th>
                    <th class="text-left" colspan="3">________________________________________________</th>
                    <th class="text-left">CODIGO:</th>
                    <th class="text-left" colspan="3">________________________________________________</th>

                </tr>
                <tr>
                    <th class="text-left">LIMPIEZA:</th>
                    <th class="text-left"> BUENA <div class="square"></div></th>
                    <th class="text-left"> REGULAR <div class="square"></div></th>
                    <th class="text-left"> MALA <div class="square"></div></th>
                    <th class="text-left">OLOR:</th>
                    <th class="text-left"> BUENA <div class="square"></div></th>
                    <th class="text-left"> REGULAR <div class="square"></div></th>
                    <th class="text-left"> MALA <div class="square"></div></th>
                </tr>
            </table>

            <table class="table-head" width="50%">
                <tr>
                    <th class="text-left">ESTADO DE PUERTAS:</th>
                    <th class="text-left"> BUENA <div class="square"></div></th>
                    <th class="text-left"> REGULAR <div class="square"></div></th>
                    <th class="text-left"> MALA <div class="square"></div></th>

                </tr>
                <tr>
                    <th class="text-left">ESTADO CONTENEDOR :</th>
                    <th class="text-left"> BUENA <div class="square"></div></th>
                    <th class="text-left"> REGULAR <div class="square"></div></th>
                    <th class="text-left"> MALA <div class="square"></div></th>
                </tr>
                <tr>
                    <th class="text-left">PRESENTA OXIDACION:</th>
                    <th class="text-left"> SI <div class="square"></div></th>
                    <th class="text-left"> NO <div class="square"></div></th>
                </tr>
            </table>
            <table class="table-head" width="100%">
                <tr>
                    <th class="text-left">OBSERVACION:</th>
                    <th class="text-left" colspan="6"> __________________________________________________________________________________________________________ </th>
                </tr>
            </table>
            <table class="table-head" width="70%">
                <tr>
                    <th class="text-left">CONDICION:</th>
                    <th class="text-left"> APROBADO: <div class="square"></div></th>
                    <th class="text-left"> RECHAZADO: <div class="square"></div></th>
                </tr>
            </table>
            <table class="table-head" width="100%">
                <tr>
                    <th class="text-left">HORA INICIO:</th>
                    <th class="text-left"> ____________ </th>
                    <th class="text-left">HORA TERMINO:</th>
                    <th class="text-left"> ____________ </th>
                    <th class="text-left">TIEMPO CARGA:</th>
                    <th class="text-left"> ____________ </th>
                </tr>
            </table>
        </div>
        <div class="content">
            <table class="table" width="100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width:45px">BODEGA</th>
                        <th class="text-center">UBIC.</th>
                        <th class="text-center" style="width:10px">A/R</th>
                        <th class="text-center" style="width:250px">DESCRIPCION</th>
                        <th class="text-center">N° PALLET</th>
                        <th class="text-center">CANT</th>
                        <th class="text-center">LOTE</th>
                        <th class="text-center">V/U Meses</th>
                        <th class="text-center">OBSERVACION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($egreso->detalles as $detalle)
                        <tr>
                            <td class="text-center smaller-text">{{$detalle->bodega}}</td>
                            <td class="text-center">{{$detalle->posicion}}</td>
                            <td class="text-left"></td>
                            <td class="text-left">{{$detalle->item->descripcion}}</td>
                            <td class="text-left">{{$detalle->pallet_num}}</td>
                            <td class="text-right">{{$detalle->cantidad}}</td>
                            <td class="text-left">{{$detalle->lote}}</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
