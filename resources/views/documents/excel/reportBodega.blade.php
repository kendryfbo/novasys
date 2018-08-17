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
                  <th class="text-center">pallet</th>
                  <th class="text-center">codigo</th>
                  <th class="text-center">descripcion</th>
                  <th class="text-center">cantidad</th>
                  <th class="text-center">Fecha Ing.</th>
                  <th class="text-center">Fecha Venc.</th>
                  <th class="text-center">Vida Util.</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($productos as $item)
                  <tr>
                      <th class="text-center">{{$loop->iteration}}</th>
                      <td class="text-left">{{$item->bod_descripcion}}</td>
                      <td class="text-left">{{$item->pos}}</td>
                      <td class="text-left">{{$item->pallet_num}}</td>
                      <td class="text-left">{{$item->codigo}}</td>
                      <td class="text-left">{{$item->descripcion}}</td>
                      <td class="text-left">{{$item->cantidad}}</td>
                      <td class="text-left warning">{{$item->fecha_ing}}</td>
                      <td class="text-left">{{$item->fecha_venc}}</td>
                      <td class="text-left">{{$item->vida_util}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
