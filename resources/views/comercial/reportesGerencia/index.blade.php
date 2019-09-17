@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Informe de Gerencia</h4>
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
			<form id="download" action="{{route('verInformeGerencia')}}" method="get">
				<input type="hidden" name="mes" value="{{$mes}}">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{route('verInformeGerencia')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Mes / Año :</label>
					<div class="col-lg-2">
						<input class="form-control" type="month" name="mes" value="">
					</div>

					<div class="col-lg-2">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
						@if ($clientes)
							<button form="download" class="btn btn-sm btn-default" type="submit" name="button">Descargar</button>
						@endif
					</div>

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
						<th class="text-center">Cliente</th>
						<th class="text-center">Total 2018</th>
						<th class="text-center">Total 2019</th>
						<th class="text-center">---</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($clientes as $cliente)

						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$cliente->descripcion}}</td>
							<td class="text-left">{{'$ ' . number_format($cliente->facturasIntls->sum('total'),2,",",".")}} 1 </td>
							<td class="text-right">{{'$ ' . number_format($cliente->facturasIntls->sum('total'),2,",",".")}} 2</td>
							<td class="text-right"></td>
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
