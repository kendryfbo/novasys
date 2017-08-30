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
						<th class="text-center">#</th>
						<th class="text-center">R.U.T</th>
						<th class="text-center">descripcion</th>
						<th class="text-center">giro</th>
						<th class="text-center">fono</th>
						<th class="text-center">contacto</th>
						<th class="text-center">region</th>
						<th class="text-center">Vendedor</th>
						<th class="text-center">Activo</th>
						<th class="text-center">Opciones</th>
					</tr>

				</thead>

				<tbody>

					@foreach ($clientes as $cliente)

						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$cliente->rut}}</td>
							<td>{{$cliente->descripcion}}</td>
							<td class="text-center">{{$cliente->giro}}</td>
							<td class="text-center">{{$cliente->fono}}</td>
							<td class="text-center">{{$cliente->contacto}}</td>
							<td class="text-center">{{$cliente->region->descripcion}}</td>
							<td class="text-center">{{$cliente->vendedor->nombre}}</td>
							<td class="text-center">{{$cliente->activo ? "Si" : "No"}}</td>
							<td class="text-center">

								<form style="display: inline" action="{{ url('comercial/clientesNacionales/' . $cliente->id) }}" method="get">
									<button class="btn btn-sm" type="submit"><i class="fa fa-eye" aria-hidden="true"></i></button>
								</form>

								<form style="display: inline" action="{{ url('comercial/clientesNacionales/' . $cliente->id . '/edit') }}" method="get">
									<button class="btn btn-sm" type="submit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
								</form>

								<form style="display: inline" action="{{ url('comercial/clientesNacionales/'.$cliente->id) }}" method="post">
									{{csrf_field()}}
									{{ method_field('DELETE') }}
									<button class="btn btn-sm" type="submit"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
