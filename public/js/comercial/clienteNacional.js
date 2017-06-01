var app = new Vue({

	el: '#vue-app',

	data: {
		region: $('select[name=region]').val(),
		provincias: provincias,
		provincia: provincia,
		comunas: comunas,
		comuna: comuna,
		rut: $('input[name=rut]').val(),
		rut_num: $('input[name=rut_num]').val()
	},

	methods: {

		getProvincias: function() {

			$url='/api/provincias?region=' + this.region;

			axios.get($url)
			.then(response => this.loadProvincias(response.data))
			.catch(error => this.handleError(error));
		},

		loadProvincias: function(data) {

			this.provincias = data;
		},

		getComunas: function() {

			$url='/api/comunas?provincia=' + this.provincia;

			axios.get($url)
			.then(response => this.loadComunas(response.data))
			.catch(error => this.handleError(error));
		},

		loadComunas: function(data) {

			this.comunas = data;
		},

		handleError: function(error) {
			console.log(error);
			alert(error);
		},

		updateRutNum: function(event) {

			this.rut_num = '';

			for (var i=0; i<this.rut.length; i++) {

				if (this.isNumber(this.rut.charAt(i))) {

					this.rut_num += this.rut.charAt(i);
				}
			}
		},

		isNumber: function isNumber(n){
    		return typeof(n) != "boolean" && !isNaN(n);
		}
	},

	updated() {
        $('.selectpicker').selectpicker('refresh');
    }
});
