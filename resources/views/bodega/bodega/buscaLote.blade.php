@extends('layouts.masterOperaciones')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Buscador de Lote en Egresos</h4>
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

			<!-- form -->

			<!-- /form -->
			<!-- /form -->
			<form id="clearInput" action="{{route('buscaLote')}}" method="get">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{Route('buscaLote')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">


        <label class="control-label col-lg-1">Lote :</label>
         <div class="col-lg-2">
 					<input class="form-control input-sm" name="loteNum" type="text" required>
         </div>

					<div class="col-lg-2 pull-right text-right">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
						<button form="clearInput" class="btn btn-sm btn-info" type="submit">Limpiar</button>
					</div>

				</div>
				<!-- /form-group -->

				<!-- form-group -->

				<!-- /form-group -->

				<!-- form-group -->
				<div class="form-group form-group-sm">

				</div>
				<!-- /form-group -->

			</form>
			<!-- /form -->
			<hr>
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='25' cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Lote</th>
						<th class="text-center">Orden Egreso</th>
						<th class="text-center">Cantidad</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($palletEgresoDetalles as $detalles)
					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td class="text-center">{{$detalles->lote}}</td>
						<td class="text-center"><a href="{{route('verEgreso',['numero' => $detalles->egreso->numero])}}" target="_blank"><strong>{{$detalles->egreso->numero}}</strong></a></td>
						<td class="text-center">{{$detalles->cantidad}}</td>
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
