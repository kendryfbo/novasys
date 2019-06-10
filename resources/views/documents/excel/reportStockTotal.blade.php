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
                  <th class="text-center">Código</th>
                  <th class="text-center">Descripción</th>
                  <th class="text-center">Familia</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-center">Stock Mínimo</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($productos as $item)
              @if ($item->cantidad <= $item->stock_min)
               <tr style="background-color: #FFFF00;">
                  <th class="text-center">{{$loop->iteration}}</th>
                  <td class="text-center">{{$item->codigo}}</td>
                  <td class="text-left">{{$item->descripcion}}</td>
                  <td class="text-left">{{$item->familia}}</td>
                  <td class="text-right">{{$item->cantidad}}</td>
                  <td class="text-right">{{$item->stock_min}}</td>
                </tr>
                @else
                <tr>
                  <th class="text-center">{{$loop->iteration}}</th>
                  <td class="text-center">{{$item->codigo}}</td>
                  <td class="text-left">{{$item->descripcion}}</td>
                  <td class="text-left">{{$item->familia}}</td>
                  <td class="text-right">{{$item->cantidad}}</td>
                  <td class="text-right">{{$item->stock_min}}</td>
                </tr>
                @endif
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
