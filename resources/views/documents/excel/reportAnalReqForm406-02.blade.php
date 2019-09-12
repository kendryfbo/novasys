<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Req. Premix y Mezclado</title>
    </head>

    <body>
        <!-- table -->
        <table>
            <tbody>
                <tr>
                    <td valign="middle" align="center"></td>
                    <td valign="middle" align="center" colspan="7"><img src="images/logonovafoods.png" width="116" height="44"><h2 valign="middle" align="center">FORM. REQUERIMIENTO DE MM.PP. E INSUMOS PARA PREMIX</h2></td>
                    <td valign="middle" align="center" colspan="2"><h5 valign="middle" align="center">FORM-406-02<br>Rev.: 1</h5></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <!-- table -->
        <table>
            <thead>
                <tr>
                    <th colspan="18" class="text-center">PREMIX</th>
                </tr>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center" width="15">Código</th>
                    <th class="text-center" width="50">Descripción</th>
                    <th class="text-center" width="15">Requerimiento</th>
                    <th class="text-center" width="15">Stock Premix</th>
                    <th class="text-center" width="15">Stock Bodega</th>
                    <th class="text-center" width="15">Cant. Pedida Real</th>
                    <th class="text-center" width="15">Cant. Entregada</th>
                    <th class="text-center">N° Lote</th>
                    <th class="text-center">Faltante</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($insumos as $insumo)
                @if ($insumo->requerida && $insumo->nivel_id == 2)
                <tr>
                    <th class="text-center"></th>
                    <td class="text-center">{{$insumo->codigo}}</td>
                    <td class="text-center">{{$insumo->descripcion}}</td>
                    <td class="text-right">{{abs(round($insumo->requerida,2))}}</td>
                    <td class="text-right"></td>
                    <td class="text-right">{{$insumo->total}}</td>
                    <td class="text-right"></td>
                    <td class="text-right"></td>
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
                    <th class="text-center" width="15">Código</th>
                    <th class="text-center" width="50">Descripción</th>
                    <th class="text-center" width="15">Requerimiento</th>
                    <th class="text-center" width="15">Stock Mezclado</th>
                    <th class="text-center" width="15">Stock Bodega</th>
                    <th class="text-center" width="15">Cant. Pedida Real</th>
                    <th class="text-center" width="15">Cant. Entregada</th>
                    <th class="text-center">N° Lote</th>
                    <th class="text-center">Faltante</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($insumos as $insumo)
                @if ($insumo->requerida && $insumo->nivel_id == 3)
                <tr>
                    <th class="text-center"></th>
                    <td class="text-center">{{$insumo->codigo}}</td>
                    <td class="text-center">{{$insumo->descripcion}}</td>
                    <td class="text-right">{{abs(round($insumo->requerida,2))}}</td>
                    <td class="text-right"></td>
                    <td class="text-right">{{$insumo->total}}</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
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
