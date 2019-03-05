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
                  <th class="text-center" colspan="7" align="center">FACTURAS POR COBRAR</th>
              </tr>
              <tr>
                  <th class="text-center" colspan="7">FECHA INFORME {{Carbon\Carbon::now()->format('d/m/Y')}}</th>
              </tr>
              <tr>
                  <th class="text-center">FACTURA</th>
                  <th class="text-center">CLIENTE</th>
                  <th class="text-center">FECHA EMISIÓN</th>
                  <th class="text-center">FECHA VCTO.</th>
                  <th class="text-center">DÍAS VENCIDOS</th>
                  <th class="text-center">SALDOS</th>
                  <th class="text-center">TOTAL SALDOS</th>
              </tr>
          </thead>
          <tbody>

            @foreach ($factPorCobrar as $clientes)

                @foreach ($clientes->facturasIntls as $factura)

            <tr>
              <td class="text-center">{{$factura->numero}}</td>
              <td class="text-center">{{$factura->cliente}}</td>
              <td class="text-center">{{Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y')}}</td>
              <td class="text-center">{{Carbon\Carbon::parse($factura->fecha_venc)->format('d/m/Y')}}</td>
              <td class="text-center" align="center">{{$factura->diasDiferencia}}</td>
              <td class="text-center">{{number_format($factura->deuda, 2,',','.')}}</td>
              @if ($loop->last)
                  <td class="text-center">{{number_format($clientes->total_cliente, 2,',','.')}}</td>
              @else
                  <td class="text-center"></td>
              @endif
            </tr>
        @endforeach
            @endforeach
          <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"><strong></strong></td>
              <td class="text-center"><strong></strong></td>
              <td class="text-center"></td>
          </tr>
          </tbody>


      </table>
      <!-- /table -->
  </body>
</html>
