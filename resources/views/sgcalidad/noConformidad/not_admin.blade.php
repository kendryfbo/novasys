	@extends('layouts.masterCalidad')


@section('content')
		<div class="box-body text-center">

			<h2>Usuario Sin Autorización para Administrar esta Sección.</h2>

			<h5>Para más información, comunicarse con encargado del Área Aseguramiento de Calidad</h5>
				<h4> <a href="mailto:aseguramientocalidad@novafoods.cl">aseguramientocalidad@novafoods.cl</a></h4>


		</div>


@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
