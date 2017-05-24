@extends('layouts.master')

@section('content')

	<div class="box box-solid box-default">

		<div class="box-header text-center">
			<h4>Formulas</h1>
		</div>

		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<a class="pull-right btn btn-primary" href="{{route('crearFormula')}}">Crear</a>
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
						<th class="text-center">Editar</th>
						<th class="text-center">Eliminar</th>
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
						<td class="text-center">{{$formula->autorizado_por}}</td>
						<td class="text-center">{{$formula->fecha_aut}}</td>
						<td class="text-center">
							<form action="{{route('editarFormula',['formula' => $formula->id])}}" method="get">
								<button class="btn btn-sm" type="submit" name="button">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</button>
							</form>
						</td>
						<td class="text-center">
							<form action="{{route('eliminarFormula',['formula' => $formula->id])}}" method="post">
								{{csrf_field()}}
								<button class="btn btn-sm" type="submit" name="button">
									<i class="fa fa-trash-o" aria-hidden="true"></i>
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
