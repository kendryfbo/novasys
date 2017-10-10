<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Factura Intl</title>
  </head>

  <body>

    <table>

      <thead>

        <tr>
          <th>codigo</th>
          <th>descripcion</th>
          <th>cantidad</th>
          <th>precio</th>
          <th>total</th>
        </tr>

      </thead>

      <tbody>

        @foreach ($factura->detalles as $detalle)
          <tr>
            <td>{{$detalle->id}}</td>
            <td>{{$detalle->descripcion}}</td>
            <td>{{$detalle->cantidad}}</td>
            <td>{{$detalle->precio}}</td>
            <td>{{$detalle->sub_total}}</td>
          </tr>
        @endforeach

      </tbody>
    </table>
  </body>
</html>
