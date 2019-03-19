<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Cheques Pendientes de Depósito</title>
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
              </tr>
          </thead>
          <tbody>
          @foreach ($chequesCartera as $chequeCartera)
              <tr>
                  <td class="text-center">{{$loop->iteration}}</td>
                  <td class="text-center">{{$chequeCartera->clienteNac->descripcion}}</td>
                  <td class="text-center">{{$chequeCartera->numero_cheque}}</td>
                  <td class="text-center">{{$chequeCartera->fecha_cobro}}</td>
                  <td class="text-center">{{$chequeCartera->monto}}</td>
                  <td class="text-center">{{$chequeCartera->banco->nombre_banco}}</td>
              </tr>
          @endforeach
          </tbody>
          <tr>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
                  <td class="text-center"><strong>TOTAL</strong></td>
                  <td class="text-center"><strong>{{$chequesCartera->sum('monto')}}</strong></td>
                  <td class="text-center"></td>
          </tr>
      </table>
      <!-- /table -->
  </body>
</html>
