<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Cuentas Corriente</title>
  </head>

  <body>
      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center" colspan="10" align="center">CTA. CTE. DE CLIENTE INTERNACIONAL</th>
              </tr>
              <tr>
                  <th class="text-center" colspan="10">FECHA INFORME {{Carbon\Carbon::now()->format('d/m/Y')}}</th>
              </tr>
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
                  <th class="text-center">DÍAS VENCIDOS</th>
              </tr>
          </thead>
          <tbody>
          @foreach ($factPorCobrar as $factura)
          <tr>
              <td class="text-center">{{$factura->numero}}</td>
              <td class="text-center">{{Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y')}}</td>
              <td class="text-center">{{$factura->proforma}}</td>
              <td class="text-center">{{$factura->cliente}}</td>
              <td class="text-center">Factura</td>
              <td class="text-center">{{number_format($factura->total, 2,'.',',')}}</td>
              <td class="text-center">0</td>
              @if(isset($factura->pagos[0]))
              <td class="text-center">0</td>
              @else
              <td class="text-center">{{number_format($factura->total, 2,'.',',')}}</td>
              @endif
              <td class="text-center">{{$factura->fecha_venc->format('d/m/Y')}}</td>
              <td class="text-center">{{$factura->diasDiferencia}}</td>
          </tr>
              @foreach ($factura->pagos as $pago)
              <tr>
                  <td class="text-center">{{$factura->numero}}</td>
                  <td class="text-center">{{Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y')}}</td>
                  <td class="text-center">{{$factura->proforma}}</td>
                  <td class="text-center">{{$factura->cliente}}</td>
                  <td class="text-center">Abono {{$pago->numero}}</td>
                  <td class="text-center">0</td>
                  <td class="text-center">{{number_format($pago->monto, 2,'.',',')}}</td>
                  @if ($loop->last)
                      <td class="text-center">{{number_format(($factura->total - $factura->pagos->sum('monto')), 2,'.',',')}}</td>
                  @else
                      <td class="text-center">0</td>
                  @endif
                  <td class="text-center"></td>
                  <td class="text-center"></td>
              </tr>
              @endforeach
          @endforeach
          <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"><strong>Totales</strong></td>
              <td class="text-center"><strong>{{$factPorCobrar->total_cargo}}</strong></td>
              <td class="text-center"><strong>{{$factPorCobrar->total_abono}}</strong></td>
              <td class="text-center"><strong>{{$factPorCobrar->total}}</strong></td>
              <td class="text-center"></td>
          </tr>
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
