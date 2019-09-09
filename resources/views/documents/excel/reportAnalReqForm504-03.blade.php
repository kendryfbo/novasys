<!DOCTYPE html>
<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Programa Producción</title>
    </head>

    <body>
        <!-- table -->
        <table>
            <tbody>
                <tr>
                    <td valign="middle" align="center"></td>
                    <td valign="middle" align="center" colspan="7"><img src="images/logonovafoods.png" width="116" height="44"><h2 valign="middle" align="center">PROGRAMA DE PRODUCCIÓN</h2></td>
                    <td valign="middle" align="center" colspan="2"><h5 valign="middle" align="center">FORM-504-03<br>Rev.: 0</h5></td>
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
                    <th class="text-center">#</th>
                    <th class="text-center" width="15">Código</th>
                    <th class="text-center" width="35">Descripción</th>
                    <th class="text-center" width="15">Requerimiento</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center" width="15">Premezcla</th>
                    <th class="text-center">Lote</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center" width="15">Reproceso</th>
                    <th class="text-center">Lote</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                <tr>
                    <td class="text-center"></td>
                    <td class="text-center">{{$producto->codigo}}</td>
                    <td class="text-center">{{$producto->descripcion}}</td>
                    <td class="text-center">{{$producto->cantidad}}</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- /table -->
    </body>
</html>
