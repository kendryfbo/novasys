	@extends('layouts.masterOperaciones')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Produccion Premezcla</h4>
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
			<div class="btn-group pull-right">

              <a class="btn btn-primary" href="{{route('crearProduccionPremezcla')}}">Generar Premezcla</a>
            </div>
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">numero</th>
						<th class="text-center">Descripcion</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Status</th>
						<th class="text-center">Opciones</th>
						<th class="text-center">Descontar</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($prodPremezcla as $premezcla)
					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td class="text-center">{{$premezcla->numero}}</td>
						<td class="text-center">{{$premezcla->formula->premezcla->descripcion}}</td>
						<td class="text-center">{{$premezcla->fecha_prod}}</td>
						<td class="text-center">{{$premezcla->status->descripcion}}</td>
						<td class="text-center">
							<form style="display: inline" action="{{route('editarProduccionPremezcla',['id' => $premezcla->id])}}" method="get">
								<button class="btn btn-default btn-sm" type="submit" name="button">
									<i class="fa fa-pencil-square-o fa-sm" aria-hidden="true"></i>
								</button>
							</form>
							<form style="display: inline" action="{{route('eliminarProduccionPremezcla',['id' => $premezcla->id])}}" method="post">
								{{csrf_field()}}
								{{ method_field('DELETE') }}
								<button class="btn btn-sm btn-default" type="submit">
									<i class="fa fa-trash-o fa-sm" aria-hidden="true"></i>
								</button>
							</form>
						</td>
						<td class="text-center">
							<form class="" action="{{route('crearDescProdPremezcla',['id' => $premezcla->id])}}" method="get">
								<button class="btn btn-default btn-sm" type="submit">
									<i class="fa fa-minus-circle" aria-hidden="true"></i>Descontar
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
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Produccion Premezcla Procesadas</h4>
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
						<th class="text-center">Descripcion</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Status</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($prodPremezclaCompleta as $premezcla)
					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td class="text-center">{{$premezcla->numero}}</td>
						<td class="text-center">{{$premezcla->formula->premezcla->descripcion}}</td>
						<td class="text-center">{{$premezcla->fecha_prod}}</td>
						<td class="text-center">{{$premezcla->status->descripcion}}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<!-- /table -->
		</div>
		<!-- /box-body -->

	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
