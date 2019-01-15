<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Reporte O.C. BORDEN</title>
  </head>

  <body>

      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Número</th>
                  <th class="text-center">Fecha</th>
                  <th class="text-center">Proveedor</th>
                  <th class="text-center">Condición Pago</th>
                  <th class="text-center">Área</th>
                  <th class="text-center">Total</th>
                  <th class="text-center">Moneda</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($productos->sortBy('proveedor.descripcion') as $producto)
                  <tr>
                      <th class="text-center">{{$loop->iteration}}</th>
                      <td class="text-center">{{$producto->numero}}</td>
                      <td class="text-center">{{$producto->fecha_emision}}</td>
                      <td class="text-center">{{$producto->nombreProveedor}}</td>
                      <td class="text-center">{{$producto->forma_pago}}</td>
                      <td class="text-center">{{$producto->nombreArea}}</td>
                      <td class="text-center">${{$producto->total}}</td>
                      <td class="text-center">{{$producto->moneda}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
