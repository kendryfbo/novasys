<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Analisis Requerimientos Detalle</title>
    </head>

    <body>
        <!-- table -->
        <table>
            <thead>
                <tr>
                    <td class="text-right" colspan="1" align="center"><img src="images/logonovafoods.png" width="120px" height="55px"></td>
                    <td class="text-right" colspan="15" align="center"><h2>FORMULARIO DE REQUERIMIENTO DE MATERIA PRIMA E INSUMOS PARA PRODUCCIÓN</h2></td>
                    <td class="text-right" colspan="2" align="center"><h5>FORM-406-01 <br>Rev.: 1</h5></td>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td colspan="18"></td>
                </tr>
            </tbody>
        </table>

        <!-- table -->
        <table>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center" colspan="2">Código</th>
                    <th class="text-center" colspan="4">Descripción</th>
                    <th class="text-center">UN</th>
                    <th class="text-center" colspan="2">Requerimiento</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center" colspan="2">Premezcla</th>
                    <th class="text-center">Lote</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center" colspan="2">Reproceso</th>
                    <th class="text-center">Lote</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                <tr>
                    <th class="text-center"></th>
                    <td class="text-center" colspan="2">{{$producto->codigo}}</td>
                    <td class="text-center" colspan="4">{{$producto->descripcion}}</td>
                    <td class="text-center"></td>
                    <td class="text-center" colspan="2">{{$producto->cantidad}}</td>
                    <td class="text-center"></td>
                    <td class="text-center" colspan="2"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center" colspan="2"></td>
                    <td class="text-center"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- /table -->

        <!-- table -->
        <table>
            <thead>
              <tr>
                    <th colspan="18" class="text-center">PRODUCCION</th>
              </tr>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center" colspan="2">Código</th>
                  <th class="text-center" colspan="4">Descripción</th>
                  <th class="text-center">UN</th>
                  <th class="text-center" colspan="2">Requerimiento</th>
                  <th class="text-center">Stock Planta</th>
                  <th class="text-center">Stock Bodega</th>
                  <th class="text-center" colspan="2">Cant. Pedida Real</th>
                  <th class="text-center" colspan="2">Cant. Entregada</th>
                  <th class="text-center">N° Lote</th>
                  <th class="text-center">Faltante</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($insumos as $insumo)
                @if ($insumo->requerida && $insumo->nivel_id == 1)
                <tr>
                    <th class="text-center"></th>
                    <td class="text-center" colspan="2">{{$insumo->codigo}}</td>
                    <td class="text-center" colspan="4">{{$insumo->descripcion}}</td>
                    <td class="text-right"></td>
                    <td class="text-right" colspan="2">{{abs(round($insumo->requerida,2))}}</td>
                    <td class="text-right"></td>
                    <td class="text-right">{{$insumo->total}}</td>
                    <td class="text-right" colspan="2"></td>
                    <td class="text-right" colspan="2"></td>
                    <td class="text-right"></td>
                    <td class="text-right">{{($insumo->total - $insumo->requerida) > 0 ? 0 : abs(round($insumo->requerida - $insumo->total,2))}}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        <!-- /table -->
        <!-- table -->
        <table>
            <thead>
                <tr>
                    <th colspan="18" class="text-center">PREMIX</th>
                </tr>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center" colspan="2">Código</th>
                    <th class="text-center" colspan="4">Descripción</th>
                    <th class="text-center">UN</th>
                    <th class="text-center" colspan="2">Requerimiento</th>
                    <th class="text-center">Stock Premix</th>
                    <th class="text-center">Stock Bodega</th>
                    <th class="text-center" colspan="2">Cant. Pedida Real</th>
                    <th class="text-center" colspan="2">Cant. Entregada</th>
                    <th class="text-center">N° Lote</th>
                    <th class="text-center">Faltante</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($insumos as $insumo)
                @if ($insumo->requerida && $insumo->nivel_id == 2)
                <tr>
                    <th class="text-center"></th>
                    <td class="text-center" colspan="2">{{$insumo->codigo}}</td>
                    <td class="text-center" colspan="4">{{$insumo->descripcion}}</td>
                    <td class="text-right"></td>
                    <td class="text-right" colspan="2">{{abs(round($insumo->requerida,2))}}</td>
                    <td class="text-right"></td>
                    <td class="text-right">{{$insumo->total}}</td>
                    <td class="text-right" colspan="2"></td>
                    <td class="text-right" colspan="2"></td>
                    <td class="text-right"></td>
                    <td class="text-right">{{($insumo->total - $insumo->requerida) > 0 ? 0 : abs(round($insumo->requerida - $insumo->total,2))}}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        <!-- /table -->
        <!-- table -->
        <table>
            <thead>
                <tr>
                    <th colspan="18" class="text-center">MEZCLADO</th>
                </tr>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center" colspan="2">Código</th>
                    <th class="text-center" colspan="4">Descripción</th>
                    <th class="text-center">UN</th>
                    <th class="text-center" colspan="2">Requerimiento</th>
                    <th class="text-center">Stock Mezclado</th>
                    <th class="text-center">Stock Bodega</th>
                    <th class="text-center" colspan="2">Cant. Pedida Real</th>
                    <th class="text-center" colspan="2">Cant. Entregada</th>
                    <th class="text-center">N° Lote</th>
                    <th class="text-center">Faltante</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($insumos as $insumo)
                @if ($insumo->requerida && $insumo->nivel_id == 3)
                <tr>
                    <th class="text-center"></th>
                    <td class="text-center" colspan="2">{{$insumo->codigo}}</td>
                    <td class="text-center" colspan="4">{{$insumo->descripcion}}</td>
                    <td class="text-right"></td>
                    <td class="text-right" colspan="2">{{abs(round($insumo->requerida,2))}}</td>
                    <td class="text-right"></td>
                    <td class="text-right">{{$insumo->total}}</td>
                    <td class="text-center" colspan="2"></td>
                    <td class="text-center" colspan="2"></td>
                    <td class="text-center"></td>
                    <td class="text-center">{{($insumo->total - $insumo->requerida) > 0 ? 0 : abs(round($insumo->requerida - $insumo->total,2))}}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        <!-- /table -->
    </body>
</html>
