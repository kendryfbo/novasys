var app = new Vue({
	el: '#vue-app',

	data: {
		formato: formato,
		cantBatch: cantBatch,
		niveles: niveles,
		nivel: '',
		nivelID: '',
		insumos: insumos,
		insumo: '',
		insumoID: '',
		cantxuni: 0,
		cantxcaja: 0,
		cantxbatch: 0,
		items: items,
	},

	methods: {

		loadInsumo: function(){

			for (var i = 0; i < this.insumos.length; i++) {

				if (this.insumos[i].id == this.insumoID) {

					this.insumo = this.insumos[i];
					return;
				}
			}

		},

		loadNivel: function () {

			for (var i = 0; i < this.niveles.length; i++) {

				if (this.niveles[i].id == this.nivelID) {

					this.nivel = this.niveles[i];
					return;
				}
			}
		},

		addItem: function() {

			var validate = this.validate()

			if (!validate) {
				return;
			}

			this.insumo.cantxuni = this.cantxuni;
			this.insumo.cantxcaja = this.cantxcaja;
			this.insumo.cantxbatch = this.cantxbatch;
			this.insumo.insumo_id = this.insumo.id;
			this.insumo.nivel = this.nivel;
			var insumo =  Object.assign({}, this.insumo);
			this.items.push(insumo);
			this.clearInputs();
		},

		removeItem: function(key) {

			this.items.splice(key,1);
		},

		calculate: function() {

			var pesoCaja = this.formato.peso_neto * 1000;
			var pesoUni = this.formato.peso_uni;
			this.cantxcaja = (pesoCaja * this.cantxuni) / pesoUni;
			this.cantxbatch = (this.cantBatch * this.cantxuni) / (pesoUni/1000);

		},

		validate: function() {

			if (!this.formato) {
			   alert('Debe seleccionar Producto');
			   return false;
		   }else if (!this.cantBatch) {
				alert('Debe ingresar Cantidad Batch');
				return false;
			} else if (!this.nivelID) {
				alert('Debe Seleccionar Nivel')
				return false;
			} else if (!this.insumo) {
				alert('Debe Seleccionar Insumo')
				return false;
			} else if (!this.cantxuni){
				alert('Debe Ingresar Cantidad por Unidad')
				return false;
			}else if (!this.cantxcaja){
				alert('Error en calculo de Cantidad x Caja')
				return false;
			}else if (!this.cantxbatch){
				alert('Error en calculo de Cantidad x Batch')
				return false;
			}
			return true;
		},

		clearInputs: function() {

			this.insumoID = '';
			this.insumo = '';
			this.cantxuni = '';
			this.cantxcaja = '';
			this.cantxbatch = '';
		}
	},

	watch: {

	},

	updated() {
        $('.selectpicker').selectpicker('refresh');
    }
})
