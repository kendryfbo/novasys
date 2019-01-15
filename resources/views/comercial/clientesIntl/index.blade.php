@extends('layouts.master2')


@section('content')

	<!-- box -->
	<div class="box box-solid box-default">

		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Clientes Internacionales</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearClienteIntl')}}">Crear</a>
		</div>
		<!-- /box-body -->

		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>descripcion</th>
						<th>Pais</th>
						<th>zona</th>
						<th>contacto</th>
						<th>Activo</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($clientes as $cliente)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td>{{$cliente->descripcion}}</td>
							<td>{{$cliente->pais->nombre}}</td>
							<td>{{$cliente->zona}}</td>
							<td>{{$cliente->contacto}}</td>
							<td>{{$cliente->activo ? "Si" : "No"}}</td>
							<td class="text-center">
								<form style="display: inline" action="{{ url('comercial/clientesIntl/' . $cliente->id) }}" method="get">
									<button class="btn btn-sm" type="submit">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{ url('comercial/clientesIntl/' . $cliente->id . '/edit') }}" method="get">
									<button class="btn btn-sm" type="submit">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{ url('comercial/clientesIntl/'.$cliente->id) }}" method="post">
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
