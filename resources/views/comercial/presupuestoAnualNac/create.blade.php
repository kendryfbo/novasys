@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Creación Proyección de Ventas Anual</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<form id="create" class="form-horizontal" action="{{route('guardarPresupuestoIntl')}}" method="post">
				{{ csrf_field() }}

				<h5></h5>

				<div class="form-group">

					<label class="control-label col-lg-1">Año :</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="year" required>
							<option value="{{$year - 1}}">{{$year - 1}}</option>
							<option value="{{$year}}" selected>{{$year}}</option>
							<option value="{{$year + 1}}">{{$year + 1}}</option>
						</select>
					</div>


				</div>
				<hr>
				<div class="form-group">
					<label class="control-label col-lg-1">Enero :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes1" value="1">
						<input class="form-control input-sm" type="text" name="enero" value="" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1">Febrero :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes2" value="2">
						<input class="form-control input-sm" type="text" name="febrero" value="" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1">Marzo :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes3" value="3">
						<input class="form-control input-sm" type="text" name="marzo" value="" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1">Abril :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes4" value="4">
						<input class="form-control input-sm" type="text" name="abril" value="" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1">Mayo :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes5" value="5">
						<input class="form-control input-sm" type="text" name="mayo" value="" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1">Junio :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes6" value="6">
						<input class="form-control input-sm" type="text" name="junio" value="" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1">Julio :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes7" value="7">
						<input class="form-control input-sm" type="text" name="julio" value="" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1">Agosto :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes8" value="8">
						<input class="form-control input-sm" type="text" name="agosto" value="" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1">Septiembre :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes9" value="9">
						<input class="form-control input-sm" type="text" name="septiembre" value="" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1">Octubre :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes10" value="10">
						<input class="form-control input-sm" type="text" name="octubre" value="" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1">Noviembre :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes11" value="11">
						<input class="form-control input-sm" type="text" name="noviembre" value="" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1">Diciembre :</label>
					<div class="col-lg-1">
						<input type="hidden" name="mes12" value="12">
						<input class="form-control input-sm" type="text" name="diciembre" value="" required>
					</div>
				</div>

			</form>
		</div>
		<div class="box-footer">
			 <button form="create" class="btn btn-default pull-right" name="button" value="1" type="submit">Crear</button>
		</div>


	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
