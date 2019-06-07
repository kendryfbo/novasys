<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Orden Compra Nº{{$ordenCompra->numero}}</title>

        <!-- PDF default CSS -->
        <link rel="stylesheet" href="{{asset('css/adquisicion/ordenCompra/formatoPDF.css')}}">
    </head>
    <body>

        <div>
            <img class="img-responsive" src="images/encabezado_orden_compra.jpg" alt="encabezado" width="100%">
        </div>

        <div class="title-content">
            <h3 class="num-oc">
                <br>
                <br>
                Nº{{$ordenCompra->numero}}
            </h3>
            <h4 class="date">
                <br>
                <br>
                Santiago, {{$ordenCompra->fecha_emision}}
            </h4>
            <table>
                <tr>
                    <th>R.U.T: {{$ordenCompra->centroVenta->rut}}</th>
                </tr>
                <tr>
                    <th>Dirección: {{$ordenCompra->centroVenta->descripcion}}</th>
                </tr>
                <tr>
                    <th>Fono: {{$ordenCompra->centroVenta->fono}}</th>
                </tr>
                <tr>
                    <th>E-mail: adquisiciones@novafoods.cl</th>
                </tr>
                <tr>
                    <th>Santiago Chile</th>
                </tr>
                <tr>
                    <th><br></th>
                </tr>
                <tr>
                    <th>Señores: {{$ordenCompra->proveedor->descripcion}}</th>
                    <th colspan="3"></th>
                    <th>At: {{$ordenCompra->contacto}}</th>
                </tr>
                <tr>
                    <th>R.U.T: {{$ordenCompra->proveedor->rut}}</th>
                    <th colspan="3"></th>
                    <th>Fono: {{$ordenCompra->proveedor->fono}}</th>
                </tr>
                <tr>
                    <th>Direccin: {{$ordenCompra->proveedor->direccion}}</th>
                </tr>
                <tr>
                    <th><br></th>
                </tr>
                <tr>
                    <th>Presente</th>
                </tr>
                <tr>
                    <th>Confirmo pedido de compra de:</th>
                </tr>
            </table>
        </div>

        <div class="content">
            <table class="table" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">CODIGO</th>
                        <th class="text-center">DESCRIPCION</th>
                        <th class="text-center">CANTIDAD</th>
                        <th class="text-center">UNITARIO</th>
                        <th class="text-center">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordenCompra->detalles as $detalle)
                        <tr>
                            <td class="text-center">{{$detalle->codigo}}</td>
                            <td class="text-left">{{$detalle->descripcion}}</td>
                            <td class="text-right">{{$detalle->cantidad}}</td>
                            <td class="text-right">{{number_format($detalle->precio,2)}}</td>
                            <td class="text-right">{{number_format($detalle->sub_total,2)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <table class="table table-total" width="200px">
            <tbody>
                <tr>
                    <th>SUB-TOTAL</th>
                    <th class="text-right">{{number_format($ordenCompra->sub_total,2)}}</th>
                </tr>
                <tr>
                    <th>DESCUENTO</th>
                    <th class="text-right">{{number_format($ordenCompra->descuento,2)}}</th>
                </tr>
                <tr>
                    <th>NETO</th>
                    <th class="text-right">{{number_format($ordenCompra->neto,2)}}</th>
                </tr>
                <tr>
                    <th>IMPUESTO</th>
                    <th class="text-right">{{number_format($ordenCompra->impuesto,2)}}</th>
                </tr>
                <tr>
                    <th>TOTAL</th>
                    <th class="text-right">{{number_format($ordenCompra->total,2)}}</th>
                </tr>
            </tbody>
        </table>

        <div class="footer-content">
            <p><strong>Nota:</strong> {{$ordenCompra->nota}}</p>
            <p>CONDICIONES DE PAGO: {{$ordenCompra->forma_pago}} pagadero en {{$ordenCompra->moneda}}</p>
            <p>Facturar a: {{$ordenCompra->centroVenta->descripcion}}, R.U.T:{{$ordenCompra->centroVenta->rut}}, {{$ordenCompra->centroVenta->direccion}}</p>
            <p><strong>Atentamente</strong></p>
        </div>

        <div class="footer">
            @if (empty($ordenCompra->Usuario->firma))

            @else

                <img class="img-responsive firma" src="images/{{$ordenCompra->Usuario->firma}}" alt="encabezado" width="20%">
            @endif
            <br>
            <br>
            <p><strong>{{$ordenCompra->Usuario->nombre}} {{$ordenCompra->Usuario->apellido}} ..................................................</strong>
            </p>
            <p><strong>{{$ordenCompra->centroVenta->descripcion}}</strong></p>
        </div>
    </body>
</html>
