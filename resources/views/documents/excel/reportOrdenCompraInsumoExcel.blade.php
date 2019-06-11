<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Reporte Insumos OC</title>
  </head>

  <body>
      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">RUT</th>
                  <th class="text-center">Empresa</th>
                  <th class="text-center">O.C.</th>
                  <th class="text-center">Moneda</th>
                  <th class="text-center">Fecha Emisión</th>
                  <th class="text-center">Producto</th>
                  <th class="text-center">Código</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-center">Precio</th>
                  <th class="text-center">Sub Total</th>
                  <th class="text-center">Impuesto</th>
                  <th class="text-center">Total</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($ordenes as $orden)
            <tr>
                <th class="text-center">{{$loop->iteration}}</th>
                @foreach ($orden->detalles as $detalle)
                <td class="text-center">{{$orden->proveedor->rut}}</td>
                <td class="text-center">{{$orden->proveedor->descripcion}}</td>
                <td class="text-center">{{$orden->numero}}</td>
                <td class="text-center">{{$orden->moneda}}</td>
                <td class="text-center">{{$orden->fecha_emision}}</td>
                <td class="text-center">{{$detalle->descripcion}}</td>
                <td class="text-center">{{$detalle->codigo}}</td>
                <td class="text-center">{{$detalle->cantidad}}</td>
                <td class="text-center">{{$detalle->precio}}</td>
                <td class="text-center">{{$orden->sub_total}}</td>
                <td class="text-center">{{$orden->impuesto}}</td>
                <td class="text-center">{{$orden->total}}</td>
            </tr>
                @endforeach
            @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
