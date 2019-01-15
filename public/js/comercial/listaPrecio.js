var app = new Vue({

	el: '#vue-app',

	data: {
		lista: lista,
		productos: productos,
		items: items,
		id: '',
		producto: '',
		producto_descrip: '',
		precio: '',
	},

	methods: {

		handleError: function(error) {
			console.log('load-item');
			console.log(error);
			alert(error);
		},

		insertItem: function() {
			console.log('load-item');
			var validacion = this.validarDatosItem();

			if (!validacion) {

				alert('Datos de Producto no Validos');
				return;
			}

			$url = '/api/listaPreciosDetalle/insertar';

			axios.post($url, {
				lista: this.lista,
				producto: this.producto,
				precio: this.precio
			})
			.then(response => this.refresh())
			.catch(error => this.handleError(error))
		},

		validarDatosItem: function() {
			console.log('load-item');
			var validos = false;

			if ( (this.producto) && (this.precio) ) {

					validos = true;
			}

			return validos;
		},

		loadItem: function(item) {
			console.log('load-item');

			var items = this.items;

			for (var i=0; i < items.length; i++) {

				if (item == items[i].id) {
					this.id = items[i].id;
					this.producto = items[i].producto_id;
					this.producto_descrip = items[i].descripcion;
					this.precio = items[i].precio;
				}
			}
		},

		clearItemInputs: function() {
			console.log('load-item');
			this.id = '';
			this.producto = '';
			this.producto_descrip = '';
			this.precio = '';
		},

		deleteDetalle: function(item) {
			console.log('load-item');
			$url = '/api/listaPreciosDetalle/'+ item;

			axios.delete($url)
			.then(response => this.refresh())
			.catch(error => this.handleError(error))
		},

		getDetalle: function() {
			console.log('load-item');
			$url = '/api/listaPreciosDetalle/' + this.lista;

			axios.get($url)
			.then(response => this.loadDetalle(response.data))
			.catch(error => this.handleError(error))
		},

		getDescripcion: function() {
			console.log('load-item');
			var productos = this.productos;

			for (var i=0; i < productos.length; i++) {

				if (this.producto == productos[i].id) {

					this.producto_descrip = productos[i].descripcion;
				}
			}
		},

		loadDetalle: function(data) {
			console.log('load-item');
			this.items = data;
		},

		refresh: function() {
			console.log('load-item');
			this.getDetalle();
			this.clearItemInputs();
		}
	},

	updated() {
        $('.selectpicker').selectpicker('refresh');
    }
});
