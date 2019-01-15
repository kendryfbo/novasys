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
                  <th class="text-center">precio</th>
                  <th class="text-center">precioxuni</th>
                  <th class="text-center">precioxcaja</th>
                  <th class="text-center">precioxbatch</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($detallesCosto as $detalle)
                  <tr>
                      <th class="text-center">{{$loop->iteration}}</th>
                      <td class="text-left">{{$detalle->insumo->codigo}}</td>
                      <td class="text-left">{{$detalle->insumo->descripcion}}</td>
                      <td class="text-left">{{abs(round($detalle->precio,2))}}</td>
                      <td class="text-left">{{abs(round($detalle->precioxuni,2))}}</td>
                      <td class="text-left">{{abs(round($detalle->precioxcaja,2))}}</td>
                      <td class="text-left">{{abs(round($detalle->precioxbatch,2))}}</td>
                  </tr>
              @endforeach
                  <tr>
                      <th class="text-right" colspan="3">TOTAL:</th>
                      <th class="text-right">{{abs(round($detallesCosto->totalPrecio,2))}}</th>
                      <th class="text-right">{{abs(round($detallesCosto->totalxuni,2))}}</th>
                      <th class="text-right">{{abs(round($detallesCosto->totalxcaja,2))}}</th>
                      <th class="text-right">{{abs(round($detallesCosto->totalxbatch,2))}}</th>
                  </tr>
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
