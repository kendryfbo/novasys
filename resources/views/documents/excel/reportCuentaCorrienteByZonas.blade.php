<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Cuentas Corrientes</title>
  </head>

  <body>
      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">FACTURA</th>
                  <th class="text-center">FECHA PAGO</th>
                  <th class="text-center">O.D.</th>
                  <th class="text-center">CLIENTE</th>
                  <th class="text-center">DOC. PAGO</th>
                  <th class="text-center">CARGOS</th>
                  <th class="text-center">ABONOS</th>
                  <th class="text-center">SALDOS</th>
                  <th class="text-center">FECHA VENC.</th>
              </tr>
          </thead>
          <tbody>
          @foreach ($pagos as $factura)
          <tr>
              <td class="text-center">{{$factura->numero}}</td>
              <td class="text-center">{{Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y')}}</td>
              <td class="text-center">{{$factura->proforma}}</td>
              <td class="text-center">{{$factura->cliente}}</td>
              <td class="text-center">Factura</td>
              <td class="text-center">{{number_format($factura->total, 2,'.',',')}}</td>
              <td class="text-center">---</td>
              @if (isset($factura->pagos))
              <td class="text-center">---</td>
              @else
              <td class="text-center">{{number_format($factura->total, 2,'.',',')}}</td>
              @endif
              <td class="text-center">{{$factura->fecha_venc->format('d/m/Y')}}</td>
          </tr>
              @foreach ($factura->pagos as $pago)
              <tr>
                  <td class="text-center">{{$factura->numero}}</td>
                  <td class="text-center">{{Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y')}}</td>
                  <td class="text-center">{{$factura->proforma}}</td>
                  <td class="text-center">{{$factura->cliente}}</td>
                  <td class="text-center">Abono {{$pago->numero}}</td>
                  <td class="text-center">---</td>
                  <td class="text-center">{{number_format($pago->monto, 2,'.',',')}}</td>
                  @if ($loop->last)
                      <td class="text-center">{{number_format(($factura->total - $factura->pagos->sum('monto')), 2,'.',',')}}</td>
                  @else
                      <td class="text-center">---</td>
                  @endif
                  <td class="text-center"></td>
              </tr>
              @endforeach
          @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
