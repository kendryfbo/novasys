
	@extends('layouts.masterCalidad')
	@section('content')
	<div class="box box-solid box-default">
		<div class="box-header text-center">
			<h3>Listado de No Conformidades</h3>
		</div>
	<div class="box-body text-center">


		<form id="downloadExcel" action="{{route('descargarNoConformidadesExcel',['noconformidades' => $noconformidades])}}" method="get">
			{{ csrf_field() }}
		</form>

			<div class="col-lg-1">
				<button form="downloadExcel" class="btn btn-sm btn-default" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Descargar en Excel</button>
			</div>

		<a class="pull-right btn btn-primary" href="{{route('crearNoConformidad')}}">Ingresar</a>

		<br><br>

		@if (session('status'))
			@component('components.panel')
				@slot('title')
					{{session('status')}}
				@endslot
			@endcomponent
		@endif
	    <table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
	    <thead>

	    <tr>
	    <td colspan="9" class="text-left"><label>Listado de Todas las No Conformidades </label></td>
	    </tr>

	    <tr>
	    <td width="50px"><label>N°</label></td>
	    <td width="85px"><label>Fecha Detección</label></td>
	    <td width="400px"><label>Título</label></td>
	    <td width="100px"><label>De</label></td>
	    <td width="100px"><label>Para</label></td>
	    <td width="90px"><label>Estado</label></td>
	    <td width="85px"><label>Fecha Implem.</label></td>
	    <td width="85px"><label>Fecha Término</label></td>
	    <td width="250px"><label>Gestión</label>
	    </tr>
	    </thead>
	    <tbody>
		@foreach ($noconformidades AS $sgc_nc)

			<tr>
				<td class="text-center">{{$sgc_nc->id}}</td>
				<td>{{date('d/m/Y', strtotime($sgc_nc->fecha_deteccion))}}</td>
				<td class="text-left">{{$sgc_nc->titulo}}</td>
				<td>{{$sgc_nc->desde->nombre}} {{$sgc_nc->desde->apellido}}</td>
				<td>{{$sgc_nc->para->nombre}} {{$sgc_nc->para->apellido}}</td>
				<td>{{$sgc_nc->estadonc->descrip}}  </td>
				<td>{{date('d/m/Y', strtotime($sgc_nc->fecha_implementacion))}} </td>
				<td>{{date('d/m/Y', strtotime($sgc_nc->fecha_cierre))}} </td>
				<td>
					@if ($sgc_nc->estado_id == $estadoEnviada)
						<form style="display: inline" action="{{url('sgcalidad/NoConformidades/'.$sgc_nc->id.'/editar')}}" method="get">
							<button class="btn btn-sm btn-default" type="submit" title="Contestar No Conformidad">
								<i class="fa fa-pencil-square-o fa-sm" aria-hidden="true"></i> Contestar</button>
							</form>
					@endif
					<form style="display: inline" action="{{url('sgcalidad/NoConformidades/'.$sgc_nc->id.'/administra')}}" method="get">
						<button class="btn btn-sm btn-default" type="submit" title="Administrar No Conformidad">
							<i class="fa fa-cog" aria-hidden="true"></i> Administrar</button>
					</form>
					<form style="display: inline" action="{{url('sgcalidad/NoConformidades/'.$sgc_nc->id.'/pdf')}}" method="get">
						<button class="btn btn-sm btn-default" type="submit" title="Ver o Descargar PDF">
							<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</button>
						</form>
				</td>
			</tr>
		@endforeach
		</tbody>
		</table>

	<div><br></div>
	</div>

	@endsection
	@section('scripts')
		<script src="{{asset('js/customDataTable.js')}}"></script>
	@endsection
