	@extends('layouts.masterCalidad')


@section('content')
	<div class="box box-solid box-default">
		<div class="box-header text-center">
			<h3>Acceso Documentos de Calidad</h3>
			<!--<a class="pull-right btn btn-primary" href="{{route('crearNoConformidad')}}">Ingresar</a> -->
		</div>
	<div class="box-body text-center">

	<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
		<thead>
			<tr>
					<th>Documentos</th>
				@foreach ($perfiles as $perfil)
					<th>{{$perfil->nombre}}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>

			@foreach ($documentos AS $documento)
				<tr>
					<td>{{$documento->codigo}}</td>
					@foreach ($perfiles as $perfil)
						<td> <input type="checkbox" name="" value=""> </td>
					@endforeach
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
