@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Autorizacion de Notas de Credito</h4>
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
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Factura</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Total</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($notasCredito as $nota)
						<tr>
							<!--<th class="text-center"><a href="{{route('autorizarNotaCreditoNac', ['notaCredito' => $nota->numero])}}" target="_blank">{{$nota->numero}}</a></th>-->
							<th class="text-center">{{$nota->numero}}</th>
							<td class="text-center">{{$nota->num_fact}}</td>
                            <td class="text-center">{{$nota->fecha}}</td>
							<td class="text-right">${{number_format($nota->total,0,',','.')}}</td>
							<td class="text-center">

								<div class="btn-group">
									<button form="authorize" class="btn btn-success btn-sm" type="submit"><i class="fa fa-check-circle" aria-hidden="true"></i></button>
									<button form="unauthorized" class="btn btn-danger btn-sm" type="submit">
										<i class="fa fa-ban" aria-hidden="true"></i>
									</button>
								</div>

							</td>

							<!-- Forms -->
							<form id="authorize" style="display: inline" action="{{route('autorizarNotaCreditoNac',['notaCredito' => $nota->id])}}" method="post">
								{{csrf_field()}}
							</form>
							<form id="unauthorized" style="display: inline" action="{{route('desautorizarNotaCreditoNac',['notaCredito' => $nota->id])}}" method="post">
								{{csrf_field()}}
							</form>
							<!-- /Forms -->
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
