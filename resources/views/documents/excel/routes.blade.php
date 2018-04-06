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
          <th>name</th>
          <th>prefix</th>
          <th>action</th>
          <th>controller name</th>
          <th>action method</th>
        </tr>

      </thead>

      <tbody>

        @foreach ($routes as $route)
          <tr>
            <td>{{$route['name']}}</td>
            <td>{{$route['prefix']}}</td>
            <td>{{$route['actionName']}}</td>
            <td>{{$route['controllerName']}}</td>
            <td>{{$route['actionMethod']}}</td>
          </tr>
        @endforeach

      </tbody>
    </table>
  </body>
</html>
