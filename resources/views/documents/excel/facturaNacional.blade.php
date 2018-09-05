<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Stock Total</title>
  </head>

  <body>

      <!-- table -->
      <table>
          <thead>
              <tr>
                  <th>NUMREG</th>
                  <th>RUT</th>
                  <th>RAZSOC</th>
                  <th>GIRO</th>
                  <th>COMUNA</th>
                  <th>CIUDAD</th>
                  <th>DIR</th>
                  <th>EMAIL</th>
                  <th>FONO</th>
                  <th>FORMPAGO</th>
                  <th>TIPODOC</th>
                  <th>NUMFACT</th>
                  <th>CODIGO</th>
                  <th>FECHA</th>
                  <th>VENCIMIE</th>
                  <th>DCTOTIPO</th>
                  <th>DCTOPJE</th>
                  <th>CODIGO1</th>
                  <th>DESCRIP</th>
                  <th>CANTIDAD</th>
                  <th>PRECUNIT</th>
                  <th>DESCTO</th>
                  <th>DESCRIP2</th>
                  <th>TIPODESP</th>
                  <th>INDTRAS</th>
                  <th>NOTAOBS</th>
                  <th>RAZONREF</th>
                  <th>TIPODOCREF</th>
                  <th>NUMDOCREF</th>
                  <th>FECHADOCREF</th>
                  <th>EXENTO</th>
                  <th>DCTOTO</th>
                  <th>UNMED</th>
                  <th>IMPTO</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($factura->detalles as $detalle)
                  <tr>
                      <td>{{$factura->numero}}</td>
                      <td>{{$factura->clienteNac->rut}}</td>
                      <td>{{$factura->clienteNac->descripcion}}</td>
                      <td>{{$factura->clienteNac->giro}}</td>
                      <td>{{$factura->clienteNac->comuna->descripcion}}</td>
                      <td>{{$factura->clienteNac->comuna->descripcion}}</td>
                      <td>{{$factura->direccion}}</td>
                      <td>{{$factura->clienteNac->email}}</td>
                      <td>{{$factura->clienteNac->fono}}</td>
                      <td>{{$factura->cond_pago}}</td>
                      <td>{{33}}</td>
                      <td>{{$factura->numero}}</td>
                      <td>{{$factura->clienteNac->vendedor->nombre}}</td>
                      <td>{{date('Y-m-d', strtotime($factura->fecha_emision))}}</td>
                      <td>{{date('Y-m-d', strtotime($factura->fecha_venc))}}</td>
                      <td></td>
                      <td></td>
                      <td>{{$detalle->codigo}}</td>
                      <td>{{$detalle->descripcion}}</td>
                      <td>{{$detalle->cantidad}}</td>
                      <td>{{round($detalle->precio)}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>{{$factura->observacion}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>CJ</td>
                      <td>{{round($detalle->impuesto)}}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <!-- /table -->
  </body>
</html>
