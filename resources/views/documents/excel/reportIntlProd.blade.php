<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Factura Intl</title>
  </head>

  <body>

      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">cliente</th>
                  <th class="text-center">codigo</th>
                  <th class="text-center">descripcion</th>
                  <th class="text-center">cantidad</th>
                  <th class="text-center">precio</th>
                  <th class="text-center">Total</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($detalles as $detalle)
                  <tr>
                      <th class="text-center">{{$loop->iteration}}</th>
                      <td class="text-center">{{$detalle->cliente ? $detalle->cliente: 'GENERAL'}}</td>
                      <td class="text-center">{{$detalle->codigo}}</td>
                      <td class="text-left">{{$detalle->descripcion}}</td>
                      <td class="text-right">{{$detalle->cantidad}}</td>
                      <td class="text-right">{{$detalle->precio}}</td>
                      <td class="text-right">{{number_format($detalle->total,2,",",".")}}</td>

                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
