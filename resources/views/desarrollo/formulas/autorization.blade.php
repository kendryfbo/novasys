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
						<th>Producto</th>
						<th>Generada</th>
						<th>Generada por</th>
						<th>Fecha Generación</th>
						<th>Autorizada</th>
						<th>Autorizada por</th>
						<th>Fecha Autorización</th>
						<th class="text-center">Autorizar</th>
						<th class="text-center">Desautorizar</th>
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
						<td class="text-center">{{$formula->autorizado ? "Si" : "No"}}</td>
						<td class="text-center">{{$formula->autorizada_por}}</td>
						<td class="text-center">{{$formula->fecha_aut}}</td>
						<td class="text-center">
							<form action="{{route('autorizarFormula',['formula' => $formula->id])}}" method="post">
								{{ csrf_field() }}
								<button class="btn btn-sm btn-primary" type="submit" name="button">
									<i class="fa fa-check-circle-o" aria-hidden="true"></i>
								</button>
							</form>
						</td>
						<td class="text-center">
							<form action="{{route('desautorizarFormula',['formula' => $formula->id])}}" method="post">
								{{ csrf_field() }}
								<button class="btn btn-sm btn-danger" type="submit" name="button">
									<i class="fa fa-ban" aria-hidden="true"></i>
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
