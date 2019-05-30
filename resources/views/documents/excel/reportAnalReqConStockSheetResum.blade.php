<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Analisis Requerimientos Detalle x</title>
    </head>

    <body>
        <!-- table -->
        <table>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Código</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Existencia</th>
                    <th class="text-center">Requerimiento</th>
                    <th class="text-center">Faltante</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                <tr>
                    <th class="text-center">{{$loop->iteration}}</th>
                    <td class="text-center">{{$producto->codigo}}</td>
                    <td class="text-center">{{$producto->descripcion}}</td>
                    <td class="text-right">{{$producto->stock_total}}</td>
                    <td class="text-right">{{$producto->cantidad}}</td>
                    <td class="text-right">{{$producto->cant_restante}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- /table -->

        <!-- table -->
        <table>
            <thead>
              <tr>
                    <th colspan="6" class="text-center">PRODUCCION</th>
              </tr>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Código</th>
                  <th class="text-center">Descripción</th>
                  <th class="text-center">Existencia</th>
                  <th class="text-center">Requerimiento</th>
                  <th class="text-center">Faltante</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($insumos as $insumo)
                @if ($insumo->requerida && $insumo->nivel_id == 1)
                <tr>
                    <th class="text-center">{{$loop->iteration}}</th>
                    <td class="text-center">{{$insumo->codigo}}</td>
                    <td class="text-center">{{$insumo->descripcion}}</td>
                    <td class="text-right">{{$insumo->total}}</td>
                    <td class="text-right">{{abs(round($insumo->requerida,2))}}</td>
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
                    <th colspan="6" class="text-center">PREMEZCLA</th>
                </tr>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Código</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Existencia</th>
                    <th class="text-center">Requerimiento</th>
                    <th class="text-center">Faltante</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($insumos as $insumo)
                @if ($insumo->requerida && $insumo->nivel_id == 2)
                <tr>
                    <th class="text-center">{{$loop->iteration}}</th>
                    <td class="text-center">{{$insumo->codigo}}</td>
                    <td class="text-center">{{$insumo->descripcion}}</td>
                    <td class="text-right">{{$insumo->total}}</td>
                    <td class="text-right">{{abs(round($insumo->requerida,2))}}</td>
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
                    <th colspan="6" class="text-center">MEZCLADO</th>
                </tr>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Código</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Existencia</th>
                    <th class="text-center">Requerimiento</th>
                    <th class="text-center">Faltante</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($insumos as $insumo)
                @if ($insumo->requerida && $insumo->nivel_id == 3)
                <tr>
                    <th class="text-center">{{$loop->iteration}}</th>
                    <td class="text-center">{{$insumo->codigo}}</td>
                    <td class="text-center">{{$insumo->descripcion}}</td>
                    <td class="text-right">{{$insumo->total}}</td>
                    <td class="text-right">{{abs(round($insumo->requerida,2))}}</td>
                    <td class="text-right">{{($insumo->total - $insumo->requerida) > 0 ? 0 : abs(round($insumo->requerida - $insumo->total,2))}}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        <!-- /table -->
    </body>
</html>
