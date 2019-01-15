@extends('layouts.masterOperaciones')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Stock Bodega</h4>
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

			<div class="form-horizontal">

				<div class="form-group form-group-sm">
				  <label class="control-label col-lg-1">Bodega:</label>
				  <div class="col-lg-5">
					  <input type="text" class="form-control input-sm" value="{{$bodega->descripcion}}" readonly>
				  </div>
				</div>
			</div>
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Codigo</th>
						<th class="text-left">Descripcion</th>
						<th class="text-right">cantidad</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($stocks as $stock)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$stock->codigo}}</td>
							<td class="text-left">{{$stock->descripcion}}</td>
							<td class="text-right">
								{{$stock->cantidad}}
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
