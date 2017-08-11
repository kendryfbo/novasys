@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Proformas</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearProforma')}}">Crear</a>
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Numero</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Despacho</th>
						<th class="text-center">Monto</th>
						<th class="text-center">Condicion Pago</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($proformas as $proforma)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{url('comercial/proformas/'.$proforma->numero)}}" target="_blank">{{$proforma->numero}}</a></td>
							<td class="text-center">{{$proforma->fecha_emision}}</td>
							<td>{{$proforma->cliente->descripcion}}</td>
							<td class="text-center">{{$proforma->fecha_despacho}}</td>
							<td class="text-right">{{$proforma->total}}</td>
							<td class="text-center">{{$proforma->cond_pago}}</td>
							<td class="text-center">
								<form style="display: inline" action="{{url('comercial/proformas/'.$proforma->id.'/edit')}}" method="get">
									<button class="btn btn-sm" type="submit">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{url('comercial/proformas/'.$proforma->id)}}" method="post">
									{{csrf_field()}}
									{{ method_field('DELETE') }}
									<button class="btn btn-sm" type="submit">
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

	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
