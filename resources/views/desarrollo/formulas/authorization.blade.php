@extends('layouts.master')

@section('content')

	<div class="box box-solid box-default">

		<div class="box-header text-center">
			<h4>Autorizacion de Formulas</h1>
		</div>

		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
		</div>
		<div class="box-body">
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Producto</th>
						<th class="text-center">Generada</th>
						<th class="text-center">Generada por</th>
						<th class="text-center">Fecha Generación</th>
						<th class="text-center">Autorizada</th>
						<th class="text-center">Autorizada por</th>
						<th class="text-center">Fecha Autorización</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($formulas as $formula)
					<tr>
						<th class="text-center">{{$loop->iteration}}</th>
						<td>{{$formula->producto->descripcion}}</td>
						<td class="text-center">{{$formula->generada ? "Si" : "No"}}</td>
						<td class="text-center">{{$formula->generada_por}}</td>
						<td class="text-center">{{$formula->fecha_gen}}</td>
						@if ($formula->autorizado === 1)
							<td class="text-center">Si</td>
						@elseif ($formula->autorizado === 0)
							<td class="text-center">No</td>
						@else
							<td class="text-center">Pendiente</td>

						@endif
						<td class="text-center">{{$formula->autorizada_por}}</td>
						<td class="text-center">{{$formula->fecha_aut}}</td>
						<td class="text-center">
							<form action="{{route('verAutFormula',['formula' => $formula->id])}}" method="get">
								<button class="btn btn-sm btn-default" type="submit" name="button">
									<i class="fa fa-eye" aria-hidden="true"></i> Ver
								</button>
							</form>
						</td>
					</tr>
				@endforeach

			</table>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
