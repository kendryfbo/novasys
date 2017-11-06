@extends('layouts.masterOperaciones')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Bodegas</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearBodega')}}">Crear</a>
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">descripcion</th>
						<th class="text-center">activa</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($bodegas as $bodega)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$bodega->descripcion}}</td>
							<td class="text-center">{{$bodega->activo ? 'Si':'No'}}</td>

							<td class="text-center">
								<form style="display: inline" action="{{route('editarBodega', ['id' => $bodega->id])}}" method="get">
									<button class="btn btn-sm btn-default" type="submit">
										<i class="fa fa-cog" aria-hidden="true"></i> Configurar
									</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<!-- /table -->
		</div>

	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
