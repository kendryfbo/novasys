@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Proyección de Ventas Internacional Anual</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<form class="form-horizontal" action="" method="post">
				{{ csrf_field() }}
				<div class="form-group">

					<label class="control-label col-lg-1">Año :</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="descripcion" value="{{$presupuestoIntl->year}}" readonly>
					</div>

				</div>
				<hr>
			</form>

		</div>

		<div class="box-body">
			<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

			  <thead>
				<tr>
				  <th class="text-center">#</th>
				  <th class="text-center">MES</th>
				  <th class="text-center">MONTO EN USD</th>
				</tr>
			  </thead>

			  <tbody>
					@foreach ($presupuestoIntlDetalle as $presupuesto)
					<tr>
					<td class="text-center">{{$loop->iteration}}</td>
				  <td class="text-center">{{$presupuesto->meses->descripcion}}</td>
				  <td class="text-center">{{$presupuesto->amount}}</td>
				</tr>
					@endforeach
			  </tbody>

			</table>
		</div>

	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
