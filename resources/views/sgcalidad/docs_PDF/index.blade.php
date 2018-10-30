	@extends('layouts.masterCalidad')


@section('content')
	<div class="box box-solid box-default">
		<div class="box-header text-center">
			<h3>Documentos de Calidad</h3>
			<!--<a class="pull-right btn btn-primary" href="{{route('crearNoConformidad')}}">Ingresar</a> -->
		</div>
	<div class="box-body text-center">
	<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
	<thead>

	<tr>
	<td colspan="7" class="text-left"><label></label></td>
	</tr>

	<tr>
	<td width="60px"><label>N°</label></td>
	<td width="100px"><label>Código</label></td>
	<td width="410px"><label>Título</label></td>
	<td width="100px"><label>Fecha Ult. Rev.</label></td>
	<td width="80px"><label>Versión N°</label></td>
	<td width="80px"><label>Área</label></td>
	<td width="80px"><label>Editar</label></td>
	</tr>
</thead>
	<tbody>

		@foreach ($documentosCalidad AS $sgc_docs)
			<tr>
				<td>{{ $sgc_docs->id }}</td>
				{{--<td><a href="../{{$sgc_docs->ruta_directorio}}" target="_blank">{{ $sgc_docs->codigo }}</a></td>--}}
				<td><a href="{{Route('verDocumento',['id' => $sgc_docs->id])}}" target="_blank">{{ $sgc_docs->codigo }}</a></td>
				<td>{{ $sgc_docs->titulo }}</td>
				<td>{{ date('d/m/Y', strtotime($sgc_docs->fecha_ult_rev))}}</td>
				<td>{{ $sgc_docs->revision }}</td>
				<td>{{ $sgc_docs->area->descripcion }}</td>
				<td><form action="{{route('editarDocsPDF',['docs_PDF' => $sgc_docs->id])}}" method="get">
					{{csrf_field()}}
					<button class="btn btn-sm" type="submit" name="button">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</button>
				</form></td>
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
