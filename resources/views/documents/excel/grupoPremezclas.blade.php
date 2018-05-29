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
          <th>id</th>
          <th>prem_id</th>
          <th>descripcion</th>
        </tr>

      </thead>

      <tbody>

        @foreach ($relaciones as $relacion)
          <tr>
            <td>{{$relacion['id']}}</td>
            <td>{{$relacion['prem_id']}}</td>
            <td>{{$relacion['descripcion']}}</td>
          </tr>
        @endforeach

      </tbody>
    </table>
  </body>
</html>
