<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Análisis Requerimientos Resumen</title>
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
                @foreach ($insumos as $insumo)
                    @if ($insumo->requerida)
                        <tr>
                            <th class="text-center">{{$loop->iteration}}</th>
                            <td class="text-center">{{$insumo->codigo}}</td>
                            <td class="text-center">{{$insumo->descripcion}}</td>
                            <td class="text-right">{{$insumo->total}}</td>
                            <td class="text-right">{{$insumo->requerida}}</td>
                            <td class="text-right">{{($insumo->total - $insumo->requerida) > 0 ? 0 : abs(round($insumo->requerida - $insumo->total,2))}}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <!-- /table -->
    </body>
</html>
