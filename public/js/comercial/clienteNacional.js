var app = new Vue({

	el: '#vue-app',

	data: {
		region: $('select[name=region]').val(),
		provincias: provincias,
		provincia: provincia,
		comunas: comunas,
		comuna: comuna,
		rut: $('input[name=rut]').val(),
		rut_num: $('input[name=rut_num]').val(),
		cliente: cliente,
		id_suc: '',
		descripcion_suc: '',
		direccion_suc: '',
		sucursales: sucursales
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

		updateRutNum: function() {

			this.rut_num = '';

			for (var i=0; i<this.rut.length; i++) {

				if (this.isNumber(this.rut.charAt(i))) {

					this.rut_num += this.rut.charAt(i);
				}
			}
		},

		isNumber: function isNumber(n){
    		return typeof(n) != "boolean" && !isNaN(n);
		},

		insertSucursal: function() {

			var validacion = this.validarDatosSucursal();

			if (!validacion) {

				alert('Datos de Sucursal no Validos');
				return;
			}

			$url = '/api/sucursales/insertar';

			axios.post($url, {
				id: this.id_suc,
				cliente: this.cliente,
				descripcion: this.descripcion_suc,
				direccion: this.direccion_suc
			})
			.then(response => this.refresh())
			.catch(error => this.handleError(error))
		},

		validarDatosSucursal: function() {

			var validos = false;

			if ( (this.cliente) && (this.descripcion_suc) && (this.direccion_suc) ) {

					validos = true;
			}

			return validos;
		},

		loadSucursal: function(sucursal) {

			var suc = this.sucursales;

			for (var i=0; i < suc.length; i++) {

				if (sucursal == suc[i].id) {

					this.id_suc = suc[i].id;
					this.descripcion_suc = suc[i].descripcion;
					this.direccion_suc = suc[i].direccion;
				}
			}
		},

		clearSucursalInputs: function() {

			this.id_suc = '';
			this.descripcion_suc = '';
			this.direccion_suc = '';
		},

		deleteSucursal: function(item) {

			$url = '/api/sucursales/'+ item;

			axios.delete($url)
			.then(response => this.refresh())
			.catch(error => this.handleError(error))
		},

		getSucursales: function() {

			$url = '/api/sucursales/' + this.cliente;

			axios.get($url)
			.then(response => this.loadSucursales(response.data))
			.catch(error => this.handleError(error))
		},

		loadSucursales: function(data) {

			this.sucursales = data;
		},

		refresh: function() {

			this.getSucursales();
			this.clearSucursalInputs();
		}
	},

	updated() {
        $('.selectpicker').selectpicker('refresh');
    }
});
