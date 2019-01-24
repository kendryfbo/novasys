<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Facturas Intl. x Cobrar</title>
  </head>

  <body>
      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Fact. N°</th>
                  <th class="text-center">Fecha Emisión</th>
                  <th class="text-center">Cliente</th>
                  <th class="text-center">Monto</th>
                  <th class="text-center">Abonado</th>
                  <th class="text-center">Saldo</th>
                  <th class="text-center">Doc. de Pago</th>
                  <th class="text-center">Zona</th>
                  <th class="text-center">Fecha Vcto.</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($pagos as $pago)
                  <tr>
                      <th class="text-center">{{$loop->iteration}}</th>
                      <td class="text-center">{{$pago->Factura->numero}}</td>
                      <td class="text-center">{{$pago->Factura->fecha_emision}}</td>
                      <td class="text-left">{{$pago->Factura->cliente}}</td>
                      <td class="text-center">{{$pago->Factura->total}}</td>
                      <td class="text-right">{{$pago->monto}}</td>
                      <td class="text-right">{{$pago->saldo}}</td>
                      <td class="text-center">{{$pago->numero_documento}}</td>
                      <td class="text-center">{{$pago->Factura->clienteIntl->zona}}</td>
                      <td class="text-right">{{$pago->Factura->fecha_venc->format('d-m-Y')}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
