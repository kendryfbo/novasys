<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Historial Cheques Depositados</title>
  </head>

  <body>
      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">CLIENTE</th>
                  <th class="text-center">N° CHEQUE</th>
                  <th class="text-center">FECHA VCTO.</th>
                  <th class="text-center">MONTO</th>
                  <th class="text-center">BANCO</th>
                  <th class="text-center">FECHA DEPÓSITO</th>
              </tr>
          </thead>
          <tbody>
          @foreach ($chequesDepositados as $chequeDepositado)
              <tr>
                  <td class="text-center">{{$loop->iteration}}</td>
                  <td class="text-center">{{$chequeDepositado->clienteNac->descripcion}}</td>
                  <td class="text-center">{{$chequeDepositado->numero_cheque}}</td>
                  <td class="text-center">{{Carbon\Carbon::parse($chequeDepositado->fecha_cobro)->format('d/m/Y')}}</td>
                  <td class="text-center">{{$chequeDepositado->monto}}</td>
                  <td class="text-center">{{$chequeDepositado->banco->nombre_banco}}</td>
                  <td class="text-center">{{Carbon\Carbon::parse($chequeDepositado->fecha_real_cobro)->format('d/m/Y')}}</td>
              </tr>
          @endforeach
          </tbody>
          <tr>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"><strong>TOTAL</strong></td>
                  <td class="text-center"><strong>{{number_format($chequesDepositados->sum('monto'), 0,',','.')}}</strong></td>
                  <td class="text-center"></td>
          </tr>
      </table>
      <!-- /table -->
  </body>
</html>
