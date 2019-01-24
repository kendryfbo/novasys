<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Historial Pago Factura Intl</title>
  </head>

  <body>
      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">FACTURA</th>
                  <th class="text-center">FECHA PAGO</th>
                  <th class="text-center">DOC. PAGO</th>
                  <th class="text-center">CARGOS</th>
                  <th class="text-center">ABONOS</th>
                  <th class="text-center">SALDOS</th>
          </thead>
          <tbody>
              @foreach ($pagos as $pago)
                  <tr>
                      <td class="text-center">{{$loop->iteration}}</td>
                      <td class="text-center">{{$pago->Factura->numero}}</td>
                      <td class="text-center">{{$pago->fecha_pago->format('d-m-Y')}}</td>
                      <td class="text-center">{{$pago->numero_documento}}</td>
                      <td class="text-center">{{$pago->Factura->total}}</td>
                      <td class="text-center">{{$pago->monto}}</td>
                      <td class="text-center">{{$pago->saldo}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
