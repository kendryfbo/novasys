<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Factura Intl N°{{$factura->numero}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- PDF default CSS -->
        <link rel="stylesheet" href="{{asset('css/comercial/facturaIntl/formatoPDF.css')}}">
    </head>
    <body>
        <div class="title-content">

            <h1 class="descrip-cv"><strong>{{$factura->centroVenta->descripcion}}</strong></h1>
            <h3 class="giro-cv">{{$factura->centroVenta->giro}}</h3>
            <h3 class="giro-cv">{{$factura->centroVenta->direccion}}</h3>
            <h3 class="giro-cv">Fono: {{$factura->centroVenta->fono}}</h3>
            <h3 class="giro-cv">SANTIAGO - CHILE</h3>

            <h3 class="num-proforma"><strong><i>FACTURA EXPORTACION</i></strong></h3>
            <h3 class="num-proforma"><strong><i>EXPORT INVOICE</i></strong></h3>
        </div>

        <div class="cliente-content">
            <table width="100%">
                <tbody>
                    <tr>
                        <td class="text-left">CLIENTE/CUSTOMER&nbsp; &nbsp; :</td>
                        <th>{{$factura->clienteIntl->descripcion}}</th>
                        <th></th>
                        <td class="datos-content2">COD.CLIENTE / CUSTOMER N°</td>
                        <td class="datos-content2">FACTURA N° / INVOICE N°</td>
                        <td class="datos-content2">FECHA / DATE</td>
                    </tr>
                    <tr>
                        <td class="text-left">DIRECCION/ADDRESS&nbsp; :</td>
                        <th colspan="2">{{$factura->clienteIntl->direccion}}</th>
                        <th class="datos-content2"><hr>{{$factura->clienteIntl->id}}</th>
                        <th class="datos-content2"><hr>{{$factura->numero}}</th>
                        <th class="datos-content2"><hr>{{$factura->fecha_emision_formato_correcto}}</th>
                    </tr>
                    <tr>
                        <td class="text-left">PAIS/COUNTRY&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</td>
                        <th>{{strtoupper($factura->clienteIntl->pais->nombre)}}</th>
                        <td></td>
                        <td class="datos-content2"></td>
                        <td class="datos-content2"></td>
                        <td class="datos-content2"></td>
                    </tr>
</table>
</div>

<div>
    <table class="datos-content" width="100%">
                    <tr>
                        <td class="datos-content2" colspan="3"></td>
                        <td class="datos-content2" colspan="3">DESC.MERCADERIA / GOODS DESCRIPTION</td>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="2">CLAUSULA DE VENTA/INCOTERMS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                        <th class="datos-content3">{{$factura->clau_venta}}</th>
                        <td colspan="3" rowspan="6"></td>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="2">CONDICION DE PAGO/PAYMENT TERMS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                        <th class="datos-content3">{{strtoupper($factura->forma_pago)}}</th>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="2">MONEDA DE PAGO/CURRENCY &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                        <th class="datos-content3">US$</th>
                    </tr>

                    <tr>
                        <td class="text-left" colspan="2">MEDIO DE TRANSPORTE/TRANSPORT VIA &nbsp;&nbsp;:</td>
                        <th class="datos-content3">{{strtoupper($factura->transporte)}}</th>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="2">PUERTO DE EMBARQUE/LOADING PORT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                        <th class="datos-content3">{{strtoupper($factura->puerto_emb)}}</th>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="2">PUERTO DESTINO/DISCHARGING PORT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                        <th class="datos-content3">{{$factura->puerto_dest}}</th>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-content">
            <table class="table" width="auto">
                <thead>
                    <tr>
                        <th style="width:15" class="text-center">#</th>
                        <th style="width:100" class="text-center">CODIGO/CODE</th>
                        <th style="width:226" class="text-center">PRODUCTOS/PRODUCTS</th>
                        <th style="width:30" class="text-center">CANT/QTTY</th>
                        <th style="width:40" class="text-center">PRECIO/PRICE</th>
                        <th style="width:30" class="text-center">VALOR/AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($factura->detalles as $detalle)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$detalle->codigo}}</td>
                            <td>
                                {{$detalle->producto->marca->descripcion . " "}}
                                {{$detalle->producto->formato->descripcion . " "}}
                                {{$detalle->producto->sabor->descrip_ing . " "}}
                            </td>
                            <td class="text-right">{{$detalle->cantidad}}</td>
                            <td class="text-right">{{number_format($detalle->precio,2)}}</td>
                            <td class="text-right">{{number_format($detalle->sub_total,2)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <table class="table table-pesos" width="100%">
            <tbody>
                <tr>
                    <th>TOTAL CAJAS / TOTAL CASES</th>
                    <th>TOTAL KG / GROSS WEIGHT</th>
                    <th>PESO NETO / NET WEIGHT</th>
                    <th>TOTAL VOLUMEN / VOLUME</th>
                    <th class="text-right">FOB :</th>
                    <th class="text-right">{{number_format($factura->fob,2)}}</th>
                </tr>
                <tr>
                    <th class="text-right" rowspan="2">{{number_format($factura->detalles->sum('cantidad'))}}</th>
                    <th class="text-right" rowspan="2">{{number_format($factura->proformaInfo->peso_neto,2)}}</th>
                    <th class="text-right" rowspan="2">{{number_format($factura->proformaInfo->peso_bruto,2)}}</th>
                    <th class="text-right" rowspan="2">{{number_format($factura->proformaInfo->volumen,2)}}</th>
                    <th class="text-right">FREIGHT :</th>
                    <th class="text-right">{{number_format($factura->freight,2)}}</th>
                </tr>
                <tr>
                    <th class="text-right">TOTAL {{$factura->clau_venta}}:</th>
                    <th class="text-right">{{number_format($factura->total,2)}}</th>
                </tr>
            </tbody>
        </table>


    </body>
</html>
