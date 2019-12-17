	@extends('layouts.masterInforme')

	@section('content')
		<!-- box -->
		<div id="vue-app" class="box box-solid box-default">
			<!-- box-header -->
			<div class="box-header text-center">
				<h4>Ventas Mercado Internacional </h4>
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


				<div class="form_group" id="curve_chart" style="width: auto; height: 400px"></div>

				<form id="filter" class="form-group form-group-sm" method="get" action="{{route('cierreMesIntl')}}">

						<label class="control-label col-sm-1">{{$years[0]}}</label>
						<div class="col-sm-1">
							<input type="checkbox" name="actualYear" {{$yearOptions[0] ? 'checked' : ''}}>
						</div>
						<label class="control-label col-sm-1">{{$years[1]}}</label>
						<div class="col-sm-1">
							<input type="checkbox" name="lastYear" {{$yearOptions[1] ? 'checked' : ''}}>
						</div>
						<label class="control-label col-sm-1">{{$years[2]}}</label>
						<div class="col-sm-1">
							<input type="checkbox" name="previousYear" {{$yearOptions[2] ? 'checked' : ''}}>
						</div>
						<input type="hidden" name="filter" value="true" checked>

				 	 	<button type="submit" form="filter" class="btn btn-default">Filtrar</button>

				</form>

			</div>
			<!-- /box-body -->
	</div>

	@endsection

@section('scripts')
<script>

	var data = {!!json_encode($data)!!};
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/informes/cierreMes/cierreMesIntlChart.js')}}"></script>
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
