<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <title>No Conformidad PDF</title>
 <!-- Tell the browser to be responsive to screen width -->
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <!-- PDF default CSS -->
 <link rel="stylesheet" href="{{asset('css/bodega/pallet/formatoPalletPDF.css')}}">

 <style>

 </style>

</head>
<body>
    <table width="100%" border="1">
  <tr>
    <td rowspan="2" class="text-center" width="30%"><img src="images/logonovafoods.png" width="200px" height="70px"></td>
    <td rowspan="2" class="text-center" width="50%"><h4>REGISTRO DE NO CONFORMIDADES<br>ACCIONES CORRECTIVAS Y/O PREVENTIVAS</h4></td></td>
    <td class="text-center" width="20%"><h5>FORM-600-04<br>REV.03</h5></td>
  </tr>
  <tr>
    <td class="text-center"><h4>N° {{ $noconformidades[0]->id }}</h4></td>
  </tr>
</table>
<br />
<table width="100%" border="1">
  <tr>
    <td width="30%">Area en que se detecta :</td>
    <td width="35%">{{ $noconformidades[0]->area->descripcion }}</td>
    <td colspan="2" class="text-center" width="35%"><strong>Origen</strong></td>
  </tr>
  <tr>
    <td>Fecha de detección :</td>
    <td>{{ date('d/m/Y', strtotime($noconformidades[0]->fecha_deteccion)) }}</td>
    <td>Auditoría Interna :</td>
    <td class="text-center">@if ($noconformidades[0]->OAI == 'on')
    Sí @else
        No
    @endif</td>
  </tr>
  <tr>
    <td>Nombre Persona que detecta :</td>
    <td>{{ $noconformidades[0]->persona_detecta }}</td>
    <td>Reclamo del Cliente :</td>
    <td class="text-center">@if ($noconformidades[0]->ORC == 'on')
    Sí @else
        No
    @endif</td>
  </tr>
  <tr>
    <td>Estado Actual</td>
    <td>{{ $noconformidades[0]->estadonc->descrip }}
    </td>
    <td>Proceso :</td>
    <td class="text-center">@if ($noconformidades[0]->OPR == 'on')
    Sí @else
        No
    @endif</td>
  </tr>
  <tr>
    <td colspan="2"></td>
    <td>Real :</td>
    <td class="text-center">@if ($noconformidades[0]->ORE == 'on')
    Sí @else
        No
    @endif</td>
  </tr>
  <tr>
    <td>Norma / Procedimiento / Instructivo :</td>
    <td>{{ $noconformidades[0]->npi }}</td>
    <td>Potencial :</td>
    <td class="text-center">@if ($noconformidades[0]->OPO == 'on')
    Sí @else
        No
    @endif</td>
  </tr>
  <tr>
    <td>Cláusula :</td>
    <td>{{ $noconformidades[0]->clausula }}</td>
    <td>Observación :</td>
    <td class="text-center">@if ($noconformidades[0]->OBS == 'on')
    Sí @else
        No
    @endif</td>
  </tr>
</table>

<br>

<table width="697px" border="1">
  <tr>
    <td colspan="3"><br><strong>SECCIÓN I : DESCRIPCIÓN DE LA NO CONFORMIDAD</strong><br><br>
  <strong>Detalle :</strong> {{ wordwrap($noconformidades[0]->descripcion, 55, "\n", 1) }}<br></td>
  </tr>
  <tr>
    <td colspan="3"><br><strong>SECCIÓN II : ANÁLISIS DE LA CAUSA &amp; ACCIÓN PROPUESTA</strong><br><br>
        <strong>Detalle : Análisis Causa</strong><br>{{ wordwrap($noconformidades[0]->analisis_causa, 55, "\n", 1) }} <br><br>
        <strong>Detalle : Acción Propuesta</strong><br>{{ wordwrap($noconformidades[0]->accion_propuesta, 55, "\n", 1) }}<br><br></td>
  </tr>
  <tr>
    <td width="170px">Fecha de Implementación :</td>
    <td width="100px" class="text-center">{{ date('d/m/Y', strtotime($noconformidades[0]->fecha_implementacion)) }}</td>
    <td>&nbsp; Responsable del Área : {{ $noconformidades[0]->para->cargo }} | {{ $noconformidades[0]->para->nombre }} {{ $noconformidades[0]->para->apellido }}</td>
  </tr>
  <tr>
    <td colspan="3"><br><strong>SECCIÓN III : SEGUIMIENTO DE LA ACCIÓN</strong><br><br><strong>Detalle :</strong> {{ wordwrap($noconformidades[0]->seguimiento_accion, 55, "\n", 1) }}</td>
  </tr>
    <tr>
    <td>Fecha de Cierre :</td>
    <td class="text-center">{{ date('d/m/Y', strtotime($noconformidades[0]->fecha_cierre)) }}</td>
    <td>&nbsp; Responsable del Área : Aseguramiento de Calidad.</td>
  </tr>
</table>
</body>
</html>
