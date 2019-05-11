@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Plan de Produccion</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<form class="form-horizontal" action="" method="post">
				{{ csrf_field() }}
				<div class="form-group">

					<label class="control-label col-lg-1">Descripcion:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="descripcion" value="{{$planProduccion->descripcion}}" readonly>
					</div>
					<label class="control-label col-lg-1">Fecha:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="date" name="fecha_emision" value="{{$planProduccion->fecha_emision}}" readonly>
					</div>

				</div>
				<hr>
			</form>

		</div>

		<div class="box-body">
			<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

			  <thead>
				<tr>
				  <th class="text-center">#</th>
				  <th class="text-center">CODIGO</th>
				  <th class="text-center">DESCRIPCION</th>
				  <th class="text-center">CANTIDAD</th>
				</tr>
			  </thead>

			  <tbody>
					@foreach ($planProduccion->detalles as $detalle)
						<tr>
						  <td class="text-center">{{$loop->iteration}}</td>
						  <td class="text-center">{{$detalle->producto->codigo}}</td>
						  <td>{{$detalle->producto->descripcion}}</td>
						  <td class="text-right">{{$detalle->cantidad}}</td>
						</tr>
					@endforeach
			  </tbody>

			</table>
		</div>

		<div class="box-footer">
			<form style="display: inline" action="{{Route('verPlanProduccionConStock',['plan_id' => $planProduccion->id])}}" method="post">
				{{csrf_field()}}
				<button class="btn btn-default pull-right" type="submit">Analisis Con Existencia</button>
			</form>

			<form style="display: inline" action="{{Route('verPlanProduccionSinStock',['plan_id' => $planProduccion->id])}}" method="post">
				{{csrf_field()}}
				<button class="btn btn-default pull-right" type="submit">Analisis Sin Existencia</button>
			</form>
			
		</div>


	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
