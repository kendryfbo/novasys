<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Factura Nacional</title>
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
              @foreach ($facturas as $factura)
                  <tr>
                      <th class="text-center">{{$loop->iteration}}</th>
                      <td class="text-left">{{$factura->centro_venta}}</td>
                      <td class="text-center">{{$factura->numero}}</td>
                      <td class="text-left">{{$factura->cliente}}</td>
                      <td class="text-center">{{$factura->fecha_emision}}</td>
                      <td class="text-center">{{$factura->numero_nv}}</td>
                      <td class="text-right">{{number_format($factura->total,2,",",".")}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
