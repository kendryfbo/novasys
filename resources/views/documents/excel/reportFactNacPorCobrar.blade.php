<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Facturas por Cobrar</title>
  </head>

  <body>
      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">FACTURA</th>
                  <th class="text-center">FECHA PAGO</th>
                  <th class="text-center">NOTA VENTA</th>
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
              <td class="text-center">{{$factura->numero_nv}}</td>
              <td class="text-center">{{$factura->cliente}}</td>
              <td class="text-center">Factura</td>
              <td class="text-center">{{$factura->total}}</td>
              <td class="text-center">0</td>

              @if (isset($factura->notasDebito[0]) || isset($factura->pagos[0]))
                  <td class="text-center">0</td>
              @else
                  <td class="text-center">{{$factura->deuda}}</td>
              @endif
              <td class="text-center">{{$factura->fecha_venc->format('d/m/Y')}}</td>
          </tr>

          @foreach ($factura->notasDebito as $notaDebito)
          <tr>
              <td class="text-center">{{$factura->numero}}</td>
              <td class="text-center">{{Carbon\Carbon::parse($notaDebito->fecha)->format('d/m/Y')}}</td>
              <td class="text-center">{{$factura->numero_nv}}</td>
              <td class="text-center">{{$factura->cliente}}</td>
              <td class="text-center">Nota Débito {{$notaDebito->numero}}</td>
              <td class="text-center">{{$notaDebito->total}}</td>
              <td class="text-center">0</td>
              @if ($loop->last)
              @if (isset($factura->pagos[0]))
                  <td class="text-center">0</td>
              @else
                  @if (isset($factura->notasDebito[0]))
                      <td class="text-center">{{($factura->deuda + $notaDebito->deuda)}}</td>
                  @else
                      <td class="text-center">0</td>
                  @endif
              @endif
                  @else
                      <td class="text-center">0</td>
              @endif
              <td class="text-center"></td>
          </tr>


          @endforeach

              @foreach ($factura->pagos as $pago)
              <tr>
                  <td class="text-center">{{$factura->numero}}</td>
                  <td class="text-center">{{Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y')}}</td>
                  <td class="text-center">{{$factura->proforma}}</td>
                  <td class="text-center">{{$factura->cliente}}</td>
                  <td class="text-center">Abono {{$pago->numero}}</td>
                  <td class="text-center">0</td>
                  <td class="text-center">{{$pago->monto}}</td>
                  @if ($loop->last)
                      @if (isset($pago->Factura->notasDebito[0]))
                          <td class="text-center">{{($factura->deuda + $pago->Factura->notasDebito->sum('deuda'))}}</td>
                      @else
                          <td class="text-center">{{$factura->deuda}}</td>
                      @endif
                  @else
                      <td class="text-center">0</td>
                  @endif
                  <td class="text-center"></td>
              </tr>
              @endforeach
              <tr class="active">
                  <td colspan="9"></td>
              </tr>
          @endforeach
          <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"><strong>Totales</strong></td>
              <td class="text-center"><strong>{{$pagos->total_cargo}}</strong></td>
              <td class="text-center"><strong>{{$pagos->total_abono}}</strong></td>
              <td class="text-center"><strong>{{$pagos->total}}</strong></td>
              <td class="text-center"></td>
          </tr>
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
