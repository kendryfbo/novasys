<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Proforma</title>
  </head>

  <body>
      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Empresa</th>
                  <th class="text-center">numero</th>
                  <th class="text-center">Cliente</th>
                  <th class="text-center">Fecha</th>
                  <th class="text-center">Proforma</th>
                  <th class="text-center">Total</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($proformas as $proforma)
                  <tr>
                      <th class="text-center">{{$loop->iteration}}</th>
                      <td class="text-left">{{$proforma->centroVenta->descripcion}}</td>
                      <td class="text-center">{{$proforma->numero}}</td>
                      <td class="text-left">{{$proforma->cliente->descripcion}}</td>
                      <td class="text-center">{{$proforma->fecha_emision}}</td>
                      <td class="text-center">{{$proforma->numero}}</td>
                      <td class="text-right">{{number_format($proforma->total,2,",",".")}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
