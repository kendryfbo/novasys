<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Reporte Termino Proceso</title>
  </head>

  <body>

      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">fecha</th>
                  <th class="text-center">usuario</th>
                  <th class="text-center">descripcion</th>
                  <th class="text-center">U.Prod</th>
                  <th class="text-center">U.Rech</th>
                  <th class="text-center">Pallet</th>
                  <th class="text-center">Maquina</th>
                  <th class="text-center">Operador</th>
                  <th class="text-center">Turno</th>
                  <th class="text-center">Lote</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($procesos as $item)
                  <tr>
                      <th class="text-center">{{$loop->iteration}}</th>
                      <td class="text-left">{{$item->fecha_prod}}</td>
                      <td class="text-left">{{$item->usuario->nombre}}</td>
                      <td class="text-left">{{$item->producto->descripcion}}</td>
                      <td class="text-left">{{$item->producidas}}</td>
                      <td class="text-left">{{$item->rechazadas}}</td>
                      <td class="text-left">{{"PENDIENTE"}}</td>
                      <td class="text-left warning">{{$item->maquina}}</td>
                      <td class="text-left">{{$item->operador}}</td>
                      <td class="text-left">{{$item->turno}}</td>
                      <td class="text-left">{{$item->lote}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
