<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Listado de No Conformidades</title>
  </head>

  <body>

      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th>ID</th>
                  <th>FECHA_DETECCIÓN</th>
                  <th>TÍTULO</th>
                  <th>DE</th>
                  <th>PARA</th>
                  <th>ESTADO</th>
                  <th>FECHA IMPLEMENTACIÓN</th>
                  <th>FECHA TÉRMINO</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($noconformidades as $detalle)
                  <tr>
                      <td>{{$detalle->id}}</td>
                      <td>{{ date_format(date_create($detalle->fecha_deteccion),'d/m/Y') }}</td>
                      <td>{{$detalle->titulo}}</td>
                      <td>{{$detalle->desde->nombre}} {{$detalle->desde->apellido}}</td>
                      <td>{{$detalle->para->nombre}} {{$detalle->para->apellido}}</td>
                      <td>{{$detalle->estadonc->descrip}}</td>
                      <td>{{ date_format(date_create($detalle->fecha_implementacion),'d/m/Y') }}</td>
                      <td>{{ date_format(date_create($detalle->fecha_cierre),'d/m/Y') }}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
