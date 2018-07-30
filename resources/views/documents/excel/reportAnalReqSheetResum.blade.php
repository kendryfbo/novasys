<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Analisis Requerimientos Resumen</title>
    </head>

    <body>
        <!-- table -->
        <table>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">codigo</th>
                    <th class="text-center">descripcion</th>
                    <th class="text-center">requerimiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                <tr>
                    <th class="text-center">{{$loop->iteration}}</th>
                    <td class="text-center">{{$producto->codigo}}</td>
                    <td class="text-center">{{$producto->descripcion}}</td>
                    <td class="text-right">{{$producto->cantidad}}</td>
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
                    <th class="text-center">codigo</th>
                    <th class="text-center">descripcion</th>
                    <th class="text-center">existencia</th>
                    <th class="text-center">requerimiento</th>
                    <th class="text-center">faltante</th>
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
                    <th class="text-center">codigo</th>
                    <th class="text-center">descripcion</th>
                    <th class="text-center">existencia</th>
                    <th class="text-center">requerimiento</th>
                    <th class="text-center">faltante</th>
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
                    <th class="text-center">codigo</th>
                    <th class="text-center">descripcion</th>
                    <th class="text-center">existencia</th>
                    <th class="text-center">requerimiento</th>
                    <th class="text-center">faltante</th>
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
