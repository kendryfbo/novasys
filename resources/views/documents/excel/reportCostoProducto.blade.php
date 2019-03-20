<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Costos x Productol</title>
  </head>

  <body>

      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Código</th>
                  <th class="text-center">Producto</th>
                  <th class="text-center">Costo USD</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($costosProducto as $costoProducto)
                  <tr>
                      <td class="text-center">{{$loop->iteration}}</td>
                      <td class="text-center">{{$costoProducto->codigo}}</td>
                      <td class="text-center">{{$costoProducto->descripcion}}</td>
                      <td class="text-center">{{number_format($costoProducto->total, 4,'.',',')}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
