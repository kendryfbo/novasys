@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ingresos por Procesar</h4>
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

            <div class="btn-group pull-right">
				<a class="btn btn-primary" href="{{route('ingOC')}}">Ingreso Orden de Compra</a>
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						Devolucion <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{route('crearIngDevolucionMP')}}">Materia Prima</a></li>
						<li><a href="{{route('crearIngDevolucionPM')}}">Premezcla</a></li>
						<li><a href="#">Reproceso</a></li>
						<li><a href="{{route('crearIngDevolucionPT')}}">Producto Terminado</a></li>
					</ul>
				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					    Ingreso Manual <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
					  <li><a href="{{route('crearIngManualMP')}}">Materia Prima</a></li>
					  <li><a href="{{route('crearIngManualPM')}}">Premezcla</a></li>
					  <li><a href="#">Reproceso</a></li>
					  <li><a href="{{route('crearIngManualPT')}}">Producto Terminado</a></li>
					</ul>
				</div>
            </div>

		</div>
		<!-- /box-body -->

		<!-- box-body -->
		<div class="box-body">

			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">numero</th>
						<th class="text-center">descripcion</th>
						<th class="text-center">Tipo Ingreso</th>
						<th class="text-center">fecha</th>
						<th class="text-center">Usuario</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($ingresos as $ingreso)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
                            <td class="text-center">{{$ingreso->numero}}</td>
							<td class="text-left">{{$ingreso->descripcion}}</td>
							<td class="text-center">{{$ingreso->tipo->descripcion}}</td>
							<td class="text-center">{{$ingreso->fecha_ing}}</td>
							<td class="text-center">{{$ingreso->usuario->nombre}}</td>
							<td class="text-center">
								<form style="display: inline" method="get" action="{{route('verIngreso',['numero' => $ingreso->numero])}}">
									<button type="submit" class="btn btn-default btn-sm">
										<i class="fa fa-eye fa-sm" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" method="get" action="">
									{{csrf_field()}}
									<button type="submit" class="btn btn-default btn-sm">
										<i class="fa fa-pencil-square-o fa-sm" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" method="post" action="{{route('eliminarIngreso',['ingreso' => $ingreso->id])}}">
									{{csrf_field()}}
									{{ method_field('DELETE') }}
									<button type="submit" class="btn btn-default btn-sm">
										<i class="fa fa-trash-o fa-sm" aria-hidden="true"></i>
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
  	<!-- box -->
	<div id="vue-app-2" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ingresos Procesados</h4>
		</div>
		<!-- /box-header -->

		<!-- box-body -->
		<div class="box-body">

			<!-- table -->
			<table id="data-table-2" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">numero</th>
						<th class="text-center">descripcion</th>
						<th class="text-center">Tipo Ingreso</th>
						<th class="text-center">fecha</th>
						<th class="text-center">Usuario</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($ingresosProcesados as $ingreso)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
                            <td class="text-center">{{$ingreso->numero}}</td>
							<td class="text-left">{{$ingreso->descripcion}}</td>
							<td class="text-center">{{$ingreso->tipo->descripcion}}</td>
							<td class="text-center">{{$ingreso->fecha_ing}}</td>
							<td class="text-center">{{$ingreso->usuario->nombre}}</td>
							<td class="text-center">
								<form style="display: inline" method="get" action="{{route('verIngreso',['numero' => $ingreso->numero])}}">
									<button type="submit" class="btn btn-default btn-sm">
										<i class="fa fa-eye fa-sm" aria-hidden="true"></i>
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

@endsection
@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
