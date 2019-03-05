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
                  <th class="text-center">FACTURA</th>
                  <th class="text-center">FECHA PAGO</th>
                  <th class="text-center">DOC. PAGO</th>
                  <th class="text-center">CARGOS</th>
                  <th class="text-center">ABONOS</th>
                  <th class="text-center">SALDOS</th>
              </tr>
          </thead>
          <tbody>
          @foreach ($pagos as $factura)
          <tr>
              <td class="text-center">{{$factura->numero}}</td>
              <td class="text-center">{{Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y')}}</td>
              <td class="text-center">Factura</td>
              <td class="text-center">{{number_format($factura->total, 2,'.',',')}}</td>
              <td class="text-center">0</td>
              @if(isset($factura->pagos[0]))
              <td class="text-center">0</td>
              @else
              <td class="text-center">{{number_format($factura->deuda, 2,'.',',')}}</td>
              @endif
          </tr>
              @foreach ($factura->pagos as $pago)
              <tr>
                  <td class="text-center">{{$factura->numero}}</td>
                  <td class="text-center">{{Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y')}}</td>
                  <td class="text-center">Abono {{$pago->numero}}</td>
                  <td class="text-center">0</td>
                  <td class="text-center">{{number_format($pago->monto, 2,'.',',')}}</td>
                  @if ($loop->last)
                      <td class="text-center">{{number_format(($factura->total - $factura->pagos->sum('monto')), 2,'.',',')}}</td>
                  @else
                      <td class="text-center">0</td>
                  @endif
              </tr>
              @endforeach
          @endforeach
          <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"><strong>Totales</strong></td>
              <td class="text-center"><strong>{{$pagos->total_cargo}}</strong></td>
              <td class="text-center"><strong>{{$pagos->total_abono}}</strong></td>
              <td class="text-center"><strong>{{$pagos->total}}</strong></td>
          </tr>
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
