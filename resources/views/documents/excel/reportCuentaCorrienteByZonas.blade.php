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
                  <th class="text-center" colspan="11" align="center">CUENTAS CORRIENTES DE CLIENTES INTERNACIONAL</th>
              </tr>
              <tr>
                  <th class="text-center" colspan="11">FECHA INFORME {{Carbon\Carbon::now()->format('d/m/Y')}}</th>
              </tr>
              <tr>
                  <th class="text-center">FACTURA</th>
                  <th class="text-center">FECHA</th>
                  <th class="text-center">O.D.</th>
                  <th class="text-center">CLIENTE</th>
                  <th class="text-center">DOC. PAGO</th>
                  <th class="text-center">CARGOS</th>
                  <th class="text-center">ABONOS</th>
                  <th class="text-center">SALDOS</th>
                  <th class="text-center">FECHA VENC.</th>
                  <th class="text-center">DÍAS VENCIDOS</th>
                  <th class="text-center">ZONA</th>
              </tr>
          </thead>
          <tbody>
          @foreach ($factPorCobrar as $clientes)

            @foreach ($clientes->facturasIntlsPagadas as $factura)

                    @if ($factura->cancelada == 1)

                    @else
          <tr>
              <td class="text-center">{{$factura->numero}}</td>
              <td class="text-center">{{Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y')}}</td>
              <td class="text-center">{{$factura->proforma}}</td>
              <td class="text-center">{{$factura->cliente}}</td>
              <td class="text-center">Factura</td>
              <td class="text-center">{{number_format($factura->total, 2,',','.')}}</td>
              <td class="text-center">0</td>
              @if(isset($factura->pagos[0]))
              <td class="text-center">0</td>
              @else
              <td class="text-center">{{number_format($factura->deuda, 2,',','.')}}</td>
              @endif
              <td class="text-center">{{$factura->fecha_venc->format('d/m/Y')}}</td>
              <td class="text-center">{{$factura->diasDiferencia}}</td>
              <td class="text-center">{{$factura->zonaCliente}}</td>
          </tr>
              @foreach ($factura->pagos as $pago)
              <tr>
                  <td class="text-center">{{$factura->numero}}</td>
                  <td class="text-center">{{Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y')}}</td>
                  <td class="text-center">{{$factura->proforma}}</td>
                  <td class="text-center">{{$factura->cliente}}</td>
                  <td class="text-center">Abono {{$pago->numero}}</td>
                  <td class="text-center">0</td>
                  <td class="text-center">{{number_format($pago->monto, 2,',','.')}}</td>
                  @if ($loop->last)
                      <td class="text-center">{{number_format(($factura->total - $factura->pagos->sum('monto')), 2,',','.')}}</td>
                  @else
                      <td class="text-center">0</td>
                  @endif
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
              </tr>
                  @endforeach
              @endif
            @endforeach

            @foreach ($clientes->facturasIntlsPagadas as $saldosFavor)
              @foreach ($saldosFavor->notaCreditoDisponible as $notaCredito)
            <tr>
                <td class="text-center">{{$notaCredito->num_fact}}</td>
                <td class="text-center">{{Carbon\Carbon::parse($notaCredito->fecha)->format('d/m/Y')}}</td>
                <td class="text-center" style="text-align:center;">N.C. {{$notaCredito->numero}}</td>
                <td class="text-center">{{$factura->cliente}}</td>
                <td class="text-center">Nota Crédito {{$notaCredito->numero}} / Fact. {{$notaCredito->num_fact}}</td>
                <td class="text-center">0</td>
                <td class="text-center">{{$notaCredito->restante}}</td>
                <td class="text-center">-{{$notaCredito->restante}}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>
              @endforeach
            @endforeach
            @foreach ($clientes->anticipos as $anticipo)
            <tr>
                <td class="text-center"></td>
                <td class="text-center">{{Carbon\Carbon::parse($anticipo->fecha_abono)->format('d/m/Y')}}</td>
                <td class="text-center"></td>
                <td class="text-center">{{$factura->cliente}}</td>
                <td class="text-center">Anticipo {{$anticipo->docu_abono}}</td>
                <td class="text-center">0</td>
                <td class="text-center">{{$anticipo->restante}}</td>
                <td class="text-center">-{{$anticipo->restante}}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>
            @endforeach

        @if ($factura->deuda == 0)
            @else
            <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"><strong>Total Cliente</strong></td>
              <td class="text-center"><strong>{{number_format($clientes->total_cargo, 2,',','.')}}</strong></td>
              <td class="text-center"><strong>{{number_format($clientes->total_abono, 2,',','.')}}</strong></td>
              <td class="text-center"><strong>{{number_format($clientes->total_cliente, 2,',','.')}}</strong></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
          </tr>
          <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
          </tr>
          @endif
         @endforeach
          <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
          </tr>
          <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
          </tr>
          @foreach ($totalesPorZona as $porZona)
          <tr>
              <td class="text-center"></td>
              <td class="text-center"><strong>{{$porZona->zona}}</strong></td>
              <td class="text-center">{{$porZona->totalDeudaPorZona}}</td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
          </tr>
          @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
