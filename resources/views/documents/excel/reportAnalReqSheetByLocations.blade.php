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
                    <th class="text-center">Ubicacion</th>
                    <th class="text-center">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($insumos as $insumo)
                    @if ($insumo->requerida)
                      @foreach ($insumo->locations as $location)
                        <tr>
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td class="text-center">{{$insumo->codigo}}</td>
                            <td class="text-center">{{$insumo->descripcion}}</td>
                            <td class="text-center">{{$location->bodega}}</td>
                            <td class="text-center">{{$location->cantidad}}</td>
                        </tr>
                      @endforeach
                      <tr>
                          <td class="text-center" colspan="5"></td>
                      </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <!-- /table -->
    </body>
</html>
