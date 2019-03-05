    <!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Deudas Vencidas</title>
  </head>

  <body>
      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center" colspan="2" align="center">DEUDAS VENCIDAS</th>
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
          @foreach ($deudasVencidas as $factura)
          <tr>
              <td class="text-center">{{$factura->cliente}}</td>
              <td class="text-center">{{number_format($factura->deudaTotal, 2,',','.')}}
          </tr>
          @endforeach
          @foreach ($deudasVencidasTotal as $total)
              <tr>
                  <td class="text-center"><strong>Total</strong></td>
                  <td class="text-center"><strong>{{$total->deudaTotalFacturas}}</strong></td>
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
