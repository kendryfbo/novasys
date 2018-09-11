<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Notas Venta</title>
  </head>

  <body>

      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Empresa</th>
                  <th class="text-center">numero</th>
                  <th class="text-center">Cliente</th>
                  <th class="text-center">Fecha</th>
                  <th class="text-center">Nota Venta</th>
                  <th class="text-center">Total</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($notasVenta as $notaVenta)
                  <tr>
                      <th class="text-center">{{$loop->iteration}}</th>
                      <td class="text-left">{{$notaVenta->centroVenta->descripcion}}</td>
                      <td class="text-center">{{$notaVenta->numero}}</td>
                      <td class="text-left">{{$notaVenta->cliente->descripcion}}</td>
                      <td class="text-center">{{$notaVenta->fecha_emision}}</td>
                      <td class="text-center">{{$notaVenta->numero}}</td>
                      <td class="text-right">{{number_format($notaVenta->total,2,",",".")}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
