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
                  <th class="text-center" colspan="10" align="center">CUENTAS CORRIENTES DE CLIENTES NACIONAL</th>
              </tr>
              <tr>
                  <th class="text-center" colspan="10">FECHA INFORME {{Carbon\Carbon::now()->format('d/m/Y')}}</th>
              </tr>
              <tr>
                  <th class="text-center">VENDEDOR</th>
                  <th class="text-center">FACTURA</th>
                  <th class="text-center">FECHA EMISIÓN</th>
                  <th class="text-center">FECHA VCTO.</th>
                  <th class="text-center">RUT</th>
                  <th class="text-center">CLIENTE</th>
                  <th class="text-center">CARGOS</th>
                  <th class="text-center">ABONOS</th>
                  <th class="text-center">SALDOS</th>
                  <th class="text-center">DÍAS VENCIDOS</th>
              </tr>
          </thead>
          <tbody>
          @foreach ($factPorCobrar as $clientes)

              <tr>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"><strong>{{$clientes->descripcion}}</strong></td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
              </tr>

                @foreach ($clientes->facturasNac as $factura)

                    @if ($factura->cancelada == 1)

                    @else
          <tr>
              <td class="text-center">{{$factura->vendedor}}</td>
              <td class="text-center">{{$factura->numero}}</td>
              <td class="text-center">{{Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y')}}</td>
              <td class="text-center">{{$factura->fecha_venc->format('d/m/Y')}}</td>
              <td class="text-center">{{$factura->cliente_rut}}</td>
              <td class="text-center">{{$factura->cliente}}</td>
              <td class="text-center">{{number_format($factura->total, 2,',','.')}}</td>
              <td class="text-center">0</td>
              @if(isset($factura->pagos[0]))
              <td class="text-center">0</td>
              @else
              <td class="text-center">{{number_format($factura->deuda, 2,',','.')}}</td>
              @endif
              <td class="text-center">{{$factura->diasDiferencia}}</td>
          </tr>
              @foreach ($factura->pagos as $pago)
              <tr>
                  <td class="text-center"></td>
                  <td class="text-center">{{$factura->numero}}</td>
                  <td class="text-center">{{Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y')}}</td>
                  <td class="text-center"></td>
                  <td class="text-center">{{$factura->cliente_rut}}</td>
                  <td class="text-center">{{$factura->cliente}}</td>
                  <td class="text-center">0</td>
                  <td class="text-center">{{number_format($pago->monto, 2,',','.')}}</td>
                  @if ($loop->last)
                      <td class="text-center">{{number_format(($factura->total - $factura->pagos->sum('monto')), 2,',','.')}}</td>
                  @else
                      <td class="text-center">0</td>
                  @endif
                  <td class="text-center"></td>
              </tr>
                  @endforeach
              @endif
            @endforeach


          <tr>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"><strong>Total Cliente</strong></td>
            <td class="text-center"><strong>{{number_format($clientes->total_cargo, 2,',','.')}}</strong></td>
            <td class="text-center"><strong>{{number_format($clientes->total_abono, 2,',','.')}}</strong></td>
            <td class="text-center"><strong>{{number_format($clientes->total_cliente, 2,',','.')}}</strong></td>
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
          </tr>
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
          </tr>
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
