@extends('layouts.masterFinanzas')


@section('content')

	<!-- box -->
	<div class="box box-solid box-default">

		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Proveedores</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearProveedor')}}">Crear</a>
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
						<th>contacto</th>
						<th>Activo</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($proveedores as $proveedor)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td>{{$proveedor->rut}}</td>
							<td>{{$proveedor->descripcion}}</td>
							<td>{{$proveedor->contacto}}</td>
							<td>{{$proveedor->activo ? "Si" : "No"}}</td>
							<td class="text-center">
								<form style="display: inline" action="{{route('verProveedor',['proveedor' => $proveedor->id])}}" method="get">
									<button class="btn btn-sm btn-default" type="submit">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{route('editarProveedor',['proveedor' => $proveedor->id])}}" method="get">
									<button class="btn btn-sm btn-default" type="submit">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{route('eliminarProveedor',['proveedor' => $proveedor->id])}}" method="post">
									{{csrf_field()}}
									{{ method_field('DELETE') }}
									<button class="btn btn-sm btn-default" type="submit">
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
