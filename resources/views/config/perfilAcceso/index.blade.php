@extends('layouts.master2')


@section('content')

	<!-- box -->
	<div class="box box-solid box-default">

		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Perfiles de Acceso</h4>
		</div>
		<!-- /box-header -->

		<!-- box-body -->
		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<div class="btn-group pull-right" role="group" aria-label="...">
				<a class="btn btn-primary" href="{{route('importarAccesos')}}">Importar Accesos</a>
				<a class="btn btn-primary" href="{{route('crearPerfilAcceso')}}">Crear</a>
			</div>
		</div>
		<!-- /box-body -->

		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Nombre</th>
						<th>descripcion</th>
						<th>Activo</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($perfiles as $perfil)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td>{{$perfil->nombre}}</td>
							<td>{{$perfil->descripcion}}</td>
							<td>{{$perfil->activo ? "Si" : "No"}}</td>
							<td class="text-center">
								<form style="display: inline" action="{{route('verPerfilAcceso',['id' => $perfil->id])}}" method="get">
									<button class="btn btn-sm" type="submit">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{route('editarPerfilAcceso',['id' => $perfil->id])}}" method="get">
									<button class="btn btn-sm" type="submit">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{route('eliminarPerfilAcceso',['id' => $perfil->id])}}" method="post">
									{{csrf_field()}}
									{{ method_field('DELETE') }}
									<button class="btn btn-sm" type="submit">
										<i class="fa fa-trash-o" aria-hidden="true"></i>
									</button>
								</form>
							</td>

						</tr>
					@endforeach
				</tbody>
			</table>
			<!-- /table -->
		</div>
		<!-- /box-body -->

	</div>
	<!-- /box -->
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
