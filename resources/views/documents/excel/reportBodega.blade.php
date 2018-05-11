<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Stock Total</title>
  </head>

  <body>

      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">bodega</th>
                  <th class="text-center">posicion</th>
                  <th class="text-center">codigo</th>
                  <th class="text-center">descripcion</th>
                  <th class="text-center">cantidad</th>
                  <th class="text-center">Fecha Ing.</th>
                  <th class="text-center">Fecha Venc.</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($productos as $item)
                  <tr>
                      <th class="text-center">{{$loop->iteration}}</th>
                      <td class="text-left">{{$item->bodega}}</td>
                      <td class="text-left">{{$item->pos}}</td>
                      <td class="text-left">{{$item->producto->codigo}}</td>
                      <td class="text-left">{{$item->producto['descripcion']}}</td>
                      <td class="text-left">{{$item->cantidad}}</td>
                      <td class="text-left warning">PENDIENTE</td>
                      <td class="text-left">{{$item->fecha_venc}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>