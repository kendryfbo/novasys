@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Notas de venta</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('notasVentas.create')}}">Crear</a>
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
						<th class="text-center">R.U.T</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Despacho</th>
						<th class="text-center">Monto</th>
						<th class="text-center">Condicion Pago</th>
						<th class="text-center">Aut.Comer</th>
						<th class="text-center">Aut.Contab</th>
						<th class="text-center">Status</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($notasVentas as $notaVenta)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{url('comercial/notasVentas/'.$notaVenta->numero)}}" target="_blank"><strong>{{$notaVenta->numero}}</strong></a></td>
							<td class="text-center">{{$notaVenta->fecha_emision}}</td>
							<td class="text-center">{{$notaVenta->cliente->rut}}</td>
							<td>{{$notaVenta->cliente->descripcion}}</td>
							<td class="text-center">{{$notaVenta->fecha_despacho}}</td>
							<td class="text-right">{{number_format($notaVenta->total,0,",",".")}}</td>
							<td class="text-center">{{$notaVenta->cond_pago}}</td>
							<td class="text-center ">
								@if (is_null($notaVenta->aut_comer))
                                    Pendiente
								@elseif ($notaVenta->aut_comer == 0)
                                    No
								@else
                                    Si
								@endif
							</td>
							<td class="text-center">
								@if (is_null($notaVenta->aut_contab))
									Pendiente
								@elseif ($notaVenta->aut_contab == 0)
									No
								@else
									Si
								@endif
							</td>
							<td class="text-center">
								{{$notaVenta->status ? 'Aprobada':'Anulada'}}
							</td>
							<td class="text-center">
								<form style="display: inline" action="{{url('comercial/notasVentas/'.$notaVenta->id.'/edit')}}" method="get">
									<button class="btn btn-sm" type="submit">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{url('comercial/notasVentas/'.$notaVenta->id)}}" method="post">
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
