<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Routes</title>
  </head>

  <body>

    <table>

      <thead>

        <tr>
          <th>NOMBRE</th>
          <th>MODULO</th>
          <th>CONTROLLER</th>
          <th>ATION</th>
        </tr>

      </thead>

      <tbody>

        @foreach ($routes as $route)
          <tr>
            <td>{{$route['nombre']}}</td>
            <td>{{$route['modulo']}}</td>
            <td>{{$route['controller']}}</td>
            <td>{{$route['action']}}</td>
          </tr>
        @endforeach

      </tbody>
    </table>
  </body>
</html>
