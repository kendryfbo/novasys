@extends('layouts.master2')


@section('content')

	<!-- box -->
	<div class="box box-solid box-default">

		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Clientes Nacionales</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('clientesNacionales.create')}}">Crear</a>
		</div>
		<!-- /box-body -->

		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>R.U.T</th>
						<th>descripcion</th>
						<th>giro</th>
						<th>fono</th>
						<th>contacto</th>
						<th>region</th>
						<th>Vendedor</th>
						<th>Activo</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($clientes as $cliente)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td>{{$cliente->rut}}</td>
							<td>{{$cliente->descripcion}}</td>
							<td>{{$cliente->giro}}</td>
							<td>{{$cliente->fono}}</td>
							<td>{{$cliente->contacto}}</td>
							<td>{{$cliente->region->descripcion}}</td>
							<td>{{$cliente->vendedor->nombre}}</td>
							<td>{{$cliente->activo ? "Si" : "No"}}</td>
							<td class="text-center">
								<button class="btn btn-sm" form="show" type="submit">
									<i class="fa fa-eye" aria-hidden="true"></i>
								</button>
								<button class="btn btn-sm" form="edit" type="submit">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</button>
								<button class="btn btn-sm" form="delete" type="submit">
									<i class="fa fa-trash-o" aria-hidden="true"></i>
								</button>
							</td>

								<form id="show" action="{{ url('comercial/clientesNacionales/' . $cliente->id) }}" method="get">
								</form>
								<form id="edit" action="{{ url('comercial/clientesNacionales/' . $cliente->id . '/edit') }}" method="get">
								</form>
								<form id="delete" action="{{ url('comercial/clientesNacionales/'.$cliente->id) }}" method="post">
									{{csrf_field()}}
									{{ method_field('DELETE') }}
								</form>
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
