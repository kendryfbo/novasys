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
          <th>codigo</th>
          <th>descripcion</th>
          <th>familia_id</th>
          <th>marca_id</th>
          <th>sabor_id</th>
          <th>formato_id</th>
          <th>activo</th>
        </tr>

      </thead>

      <tbody>

        @foreach ($premezclas as $premezcla)
          <tr>
            <td>{{$premezcla['id']}}</td>
            <td>{{$premezcla['codigo']}}</td>
            <td>{{$premezcla['descripcion']}}</td>
            <td>{{$premezcla['familia_id']}}</td>
            <td>{{$premezcla['marca_id']}}</td>
            <td>{{$premezcla['sabor_id']}}</td>
            <td>{{$premezcla['formato_id']}}</td>
            <td>{{1}}</td>
          </tr>
        @endforeach

      </tbody>
    </table>
  </body>
</html>
