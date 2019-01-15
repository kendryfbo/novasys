@extends('layouts.masterCalidad')


@section('content')
	<div class="box box-solid box-default">
		<div class="box-header text-center">
			<h3>Prueba para Enviar Mail</h3>
		</div>
	<div class="box-body text-center">

		<!-- form sendEmail-->
		<form id="sendEmail" action="{{route('enviarNoConformidad',['id' => $noconformidad->id])}}" method="post">
			{{csrf_field()}}
		</form>
		<!-- /form sendEmail-->

		<!-- form-group -->
		<div class="form-group">
			<label class="control-label col-lg-1">Email:</label>
			<div class="col-lg-2">
				<input form="sendEmail" class="form-control input-sm" type="text" name="mail" value="{{$noconformidad->para->email}}">
			</div>
			<label class="control-label col-lg-1">Observaciones:</label>
			<div class="col-lg-4">
				<input form="sendEmail" class="form-control input-sm" type="text" name="observaciones">
			</div>
			<div class="col-lg-1">
				<button form="sendEmail" type="submit" class="btn btn-default btn-sm">Email</button>
			</div>

		</div>
		<!-- /form-group -->

		</div>
	</div>
@endsection
