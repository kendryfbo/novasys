@extends('layouts.master')


@section('content')
	<div id="vue" class="container">
		@{{message}}
	</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="{{asset('vue/vue.js')}}"></script>
	<script>
		var app = new Vue({
			el: '#vue',
			data: {
				message: 'hola'
			}
		})
	</script>
@endsection
