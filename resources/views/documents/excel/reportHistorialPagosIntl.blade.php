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
                      <td class="text-center">{{$pago->numero}}</td>
                      <td class="text-center">{{$pago->fecha_pago}}</td>
                      <td class="text-center">{{$pago->tipo_doc}} {{$pago->num_doc}}</td>
                      <td class="text-center">{{$pago->cargo}}</td>
                      <td class="text-center">{{$pago->abono}}</td>
                      <td class="text-center">{{$pago->saldo}}</td>
                  </tr>
              @endforeach
              <tr>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"><strong>Total</strong></td>
                  <td class="text-center"><strong>{{$pagos->total_cargo}}</strong></td>
                  <td class="text-center"><strong>{{$pagos->total_abono}}</strong></td>
                  <td class="text-center"><strong>{{$pagos->total}}</strong></td>
              </tr>
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
