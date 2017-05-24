var app = new Vue({
	el: '#vue-app',

	data: {
		producto: '',
		formulaId: '',
		formato: '',
		batch: '',
		peso: '',
		sobre: '',
		display: '',
		nivel: '',
		familia: '',
		insumos: [],
		insumo: '',
		insumoId: '',
		insumoDescrip: '',
		cantxuni: '',
		cantxcaja: '',
		cantxbatch: '',
		items: [],
		loadingItem: false,
		loadingInsumo: false,
	},

	methods: {

		getFormula: function() {

			if (this.producto) {
				$("body").css("cursor", "progress");
				axios.post('/api/formula', {
					producto: this.producto
				})
				.then(response => this.loadFormula(response.data))
				.catch(function (error) {
					console.log(error); // Mejorar Recepcion de errores
					alert(error); // Mejorar Recepcion de errores
					$("body").css("cursor", "default");
				});
			}
		},

		loadFormula: function(data) {
			$("body").css("cursor", "default");
			this.loadingProducto = false;
			this.formulaId = data.formula_id;
			this.formato = data.formato.descripcion;
			this.peso = data.formato.peso;
			this.sobre = data.formato.sobre;
			this.display = data.formato.display;

			this.getDetalleFormula();
			this.clearInputs();
		},

		clearInputs: function() {

				this.cantxuni = '';
				this.cantxcaja = '';
				this.cantxbatch = '';
		},

		getDetalleFormula: function() {

			var url = '/api/formulaDetalle/formula/'+ this.formulaId;

			axios.get(url)
			.then(response => this.loadDetalleFormula(response.data))
			.catch(function (error) {
				console.log(error); // Mejorar Recepcion de errores
				alert(error); // Mejorar Recepcion de errores
			});
		},

		loadDetalleFormula: function(data) {
			this.loadingItem = false;
			this.items = data;
		},

		getInsumos: function() {
			this.loadingInsumo = true;
			axios.post('/api/insumos', {
				familia: this.familia
			})
			.then(response => this.loadInsumos(response.data))
			.catch(function (error) {
				console.log(error); // Mejorar Recepcion de errores
				alert(error); // Mejorar Recepcion de errores
			});
		},

		loadInsumos: function(data) {
			this.insumos = data;
			this.loadingInsumo =false;
		},

		storeItem: function() {

			var url = '/api/formulaDetalle/';

			if (!this.datosValidos()) {
				return alert("Datos no Validos..."); // mejorar respuesta a validacion de inputs
			}
			this.loadingItem = true;
			axios.post(url, {
				formula: this.formulaId,
				id: this.insumoId,
				descripcion: this.insumoDescrip,
				nivel: this.nivel,
				cantxuni: this.cantxuni,
				cantxcaja: this.cantxcaja,
				cantxbatch: this.cantxbatch,
				batch: this.batch
			})
			.then(response => this.getDetalleFormula())
			.catch(function (error) {
				this.loadingItem = false;
				console.log(error); // Mejorar Recepcion de errores
				alert(error); // Mejorar Recepcion de errores

			});
		},

		deleteItem: function(id) {

			var url = '/api/formulaDetalle/' + id;
			axios.delete(url)
			.then(response => this.getDetalleFormula())
			.catch(function (error) {
				console.log(error); // Mejorar Recepcion de errores
				alert(error); // Mejorar Recepcion de errores
			});
		},
		datosValidos: function() {

			var validos = true;
			var msg = '';

			if ( (!this.batch) || (!this.nivel) || (!this.insumo) || (!this.cantxuni) || (!this.cantxcaja) || (!this.cantxbatch)  ) {

					validos = false;
			}

			return validos;
		},

		updateInsumo: function() {

			for (var i=0; i<this.insumos.length; i++) {

				if (this.insumo == this.insumos[i].id) {

					this.insumoId = this.insumos[i].id;
					this.insumoDescrip = this.insumos[i].descripcion;
				}
			}
		},

		calcular: function() {

			this.cantxcaja = '';
			this.cantxbatch = '';

			if (this.cantxuni) {

				this.cantxcaja = this.cantxuni * this.sobre * this.display;

				if (this.batch) {

					this.cantxbatch = (this.batch * this.cantxuni) / (this.peso/1000);
				}
			}



		}
	},

	updated() {
        $('.selectpicker').selectpicker('refresh');
    }
})
