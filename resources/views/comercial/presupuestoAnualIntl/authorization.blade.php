@extends('layouts.master2')

@section('content')
	<!-- box -->
<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Autorización de Proyección de Ventas Anual</h4>
		</div>
		<!-- /box-header -->
		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Año</th>
						<th class="text-center">Versión</th>
						<th class="text-center">Fecha Ingreso</th>
						<th class="text-center">Autorización</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($proyeccionVentas as $proyeccionVenta)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$proyeccionVenta->year}}</td>
							<td class="text-center">{{$proyeccionVenta->version}}</td>
							<td class="text-center">{{\Carbon\Carbon::parse($proyeccionVenta->fecha_ingreso)->format('d/m/Y')}}</td>
							<td class="text-center">
								<form id="edit" class="form-horizontal" style="display: inline" action="{{route('autorizarProyeccionVenta', ['proyeccionVenta' => $proyeccionVenta->id])}}" method="post">
									{{csrf_field()}}
								<button class="btn btn-success btn-sm" type="submit"><i class="fa fa-check-circle" aria-hidden="true"></i></button>
								</form>
							</td>
							<!-- Forms -->
							<!-- /Forms -->
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
			<!-- /table -->
		</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
@endsection
