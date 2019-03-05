<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Estructura de Clientes</title>
  </head>

  <body>
      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center" colspan="2" align="center">ESTRUCTURA DE CLIENTES</th>
              </tr>
              <tr>
                  <th class="text-center">FECHA INFORME </th>
                  <th class="text-center">{{Carbon\Carbon::now()->format('d/m/Y')}}</th>
              </tr>
              <tr>
                  <th class="text-center">CLIENTE</th>
                  <th class="text-center">TOTAL</th>
              </tr>
          </thead>
          <tbody>
          @foreach ($pagos as $factura)
          <tr>
              <td class="text-center">{{$factura->cliente}}</td>
              <td class="text-center">{{number_format($factura->deudaTotal, 2,',','.')}}</td>
          </tr>
          @endforeach
          <tr>
              <td class="text-center"><strong></strong></td>
              <td class="text-center"><strong></strong></td>
          </tr>
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
