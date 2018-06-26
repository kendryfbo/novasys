<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>PROFORMA N°{{$proforma->numero}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- PDF default CSS -->
        <link rel="stylesheet" href="{{asset('css/comercial/proforma/formatoPDF.css')}}">
    </head>
    <body>
        <div class="title-content">

            <h2 class="descrip-cv"><strong>{{$proforma->centroVenta->descripcion}}</strong></h2>
            <p class="giro-cv"><strong>{{$proforma->centroVenta->giro}}</strong></p>
            <p class="giro-cv"><strong>{{$proforma->centroVenta->direccion}}</strong></p>
            <p class="giro-cv"><strong>Fono: {{$proforma->centroVenta->fono}}</strong></p>
            <p class="giro-cv"><strong>SANTIAGO - CHILE</p>

            <H2 class="num-proforma"><strong>PROFORMA N° {{$proforma->numero}}</strong></H2>
            <h3 class="ver-proforma"><strong>VERSION N° {{$proforma->version}}</strong></h3>
        </div>

        <div class="cliente-content">
            <div class="cliente-datos">
                <table>
                    <tbody>
                        <tr>
                            <td class="text-right">CLIENTE/CUSTOMER :</td>
                            <th>{{$proforma->cliente->descripcion}}</th>
                        </tr>
                        <tr>
                            <td class="text-right">DIRECCION/ADDRESS :</td>
                            <th>{{$proforma->cliente->direccion}}</th>
                        </tr>
                        <tr>
                            <td class="text-right">PAIS/COUNTRY :</td>
                            <th>{{strtoupper($proforma->cliente->pais)}}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="fecha">
                <p>FECHA/DATE : <strong>{{$proforma->fecha_emision}}</strong></p>
            </div>
            <div style="clear:both"></div>
        </div>
        <div class="datos-content">
            <div class="clausula-datos">
                <table>
                    <tbody>
                        <tr>
                            <td class="text-right">CLAUSULA DE VENTA/INCOTERMS :</td>
                            <th>{{$proforma->clau_venta}}</th>
                        </tr>
                        <tr>
                            <td class="text-right">CONDICION DE PAGO/PAYMENTS TERMS :</td>
                            <th>{{strtoupper($proforma->forma_pago)}}</th>
                        </tr>
                        <tr>
                            <td class="text-right">MONEDA DE PAGO/CURRENCY :</td>
                            <th>US$</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text-right">MEDIO DE TRANSPORTE/TRANSPORT VIA :</td>
                            <th>{{strtoupper($proforma->transporte)}}</th>
                        </tr>
                        <tr>
                            <td class="text-right">PUERTO DE EMBARQUE/LOADING PORT :</td>
                            <th>{{strtoupper($proforma->puerto_emb)}}</th>
                        </tr>
                        <tr>
                            <td class="text-right">PUERTO DESTINO/DISHARGING PORT :</td>
                            <th>{{$proforma->puerto_dest}}</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text-right">OBSERVACIÓN/OBSERVATIONS :</td>
                            <th>{{$proforma->nota}}</th>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="table-content">
            <table class="table" width="99%">
                <col >
                <thead>
                    <tr>
                        <th style="width:10">#</th>
                        <th style="width:10">CODIGO/CODE</th>
                        <th style="width:250">PRODUCTO/PRODUCTS</th>
                        <th style="width:10">CANT/QTY</th>
                        <th style="width:20">PRECIO/PRICE</th>
                        <th style="width:20">VALOR/VALUE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proforma->detalles as $detalle)
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
                    @foreach ($proforma->detalles as $detalle)
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
                    @foreach ($proforma->detalles as $detalle)
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
                    @foreach ($proforma->detalles as $detalle)
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

        <table class="table table-pesos" width="400px">
            <thead>
                <tr>
                    <th style="width:80px">TOTAL CAJAS / TOTAL CASES</th>
                    <th style="width:80px">TOTAL BRUTO / GROSS WEIGHT</th>
                    <th style="width:80px">TOTAL NETO / NET WEIGHT</th>
                    <th style="width:60px">VOLUMEN / VOLUME</th>
                </tr>
                <tr>
                    <th class="text-right">{{number_format($proforma->detalles->sum('cantidad'))}}</th>
                    <th class="text-right">{{number_format($proforma->peso_bruto,2)}}</th>
                    <th class="text-right">{{number_format($proforma->peso_neto,2)}}</th>
                    <th class="text-right">{{number_format($proforma->volumen,2)}}</th>
                </tr>
            </thead>
        </table>
        <table class="table table-total" width="200px">
            <tbody>
                <tr>
                    <th class="text-right">TOTAL-FOB :</th>
                    <th class="text-right">{{number_format($proforma->fob,2)}}</th>
                </tr>
                <tr>
                    <th class="text-right">FREIGHT :</th>
                    <th class="text-right">{{number_format($proforma->freight,2)}}</th>
                </tr>
                <tr>
                    <th class="text-right">INSURANCE :</th>
                    <th class="text-right">{{number_format($proforma->insurance,2)}}</th>
                </tr>
                <tr>
                    <th class="text-right">TOTAL C.I.F:</th>
                    <th class="text-right">{{number_format($proforma->total,2)}}</th>
                </tr>
            </tbody>
        </table>

    </body>
</html>
