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
                  <th class="text-center">codigo</th>
                  <th class="text-center">descripcion</th>
                  <th class="text-center">cantidad</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($productos as $item)
                  <tr>
                      <th class="text-center">{{$loop->iteration}}</th>
                      <td class="text-left">{{$item->codigo}}</td>
                      <td class="text-left">{{$item->descripcion}}</td>
                      <td class="text-left">{{$item->cantidad}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
