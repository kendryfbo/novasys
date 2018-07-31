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
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Numero</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Centro Venta</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Clausula</th>
						<th class="text-center">Pais</th>
						<th class="text-center">Total</th>
						<th class="text-center">Aut.Comer</th>
						<th class="text-center">Aut.Finanzas</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($proformas as $proforma)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{url('comercial/proformas/'.$proforma->numero)}}" target="_blank"><strong>{{$proforma->numero}}</strong></a></td>
							<td class="text-center">{{$proforma->fecha_emision}}</td>
							<td class="text-center">{{$proforma->centro_venta}}</td>
							<td>{{$proforma->cliente->descripcion}}</td>
							<td class="text-center">{{$proforma->clau_venta}}</td>
							<td class="text-center">{{$proforma->cliente->pais}}</td>
							<td class="text-right">{{'US$ ' . number_format($proforma->total,2,",",".")}}</td>
							<td class="text-center ">
								@if (is_null($proforma->aut_comer))
                                    Pendiente
								@elseif ($proforma->aut_comer == 0)
                                    No
								@else
                                    Si
								@endif
							</td>
							<td class="text-center">
								@if (is_null($proforma->aut_contab))
									Pendiente
								@elseif ($proforma->aut_contab == 0)
									No
								@else
									Si
								@endif
							</td>
							<td class="text-center">
								<form style="display: inline" action="{{url('comercial/proformas/'.$proforma->numero.'/editar')}}" method="get">
									<button class="btn btn-sm btn-default" type="submit">
										<i class="fa fa-pencil-square-o fa-sm" aria-hidden="true"></i>Editar
									</button>
								</form>
							@if (!$proforma->aut_contab)
								<form style="display: inline" action="{{route('eliminarProforma',['proforma' => $proforma->id])}}" method="post">
									{{csrf_field()}}
									{{ method_field('DELETE') }}
									<button class="btn btn-sm btn-default" type="submit">
										<i class="fa fa-trash-o fa-sm" aria-hidden="true"></i>Eliminar
									</button>
								</form>
							@endif
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
