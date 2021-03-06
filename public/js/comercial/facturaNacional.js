var app = new Vue ({

	el: '#vue-app',

	data: {

		cliente : '',
		direccion: '',
		sucursales: [],
		despacho: '',
		listaId: '',
		listaDescrip: '',
		listaDetalle: [],
		active: false,
		select: '',
		producto: '',
		codigo: '',
		descripcion: '',
		precio: '',
		descuento: 0,
		cantidad: '',
		items: [],
		subTotal: '',
		totaldescuento: '',
		neto: '',
		iaba: '',
		totalIaba: '',
		iva: '',
		total: '',
		peso_neto: '',
		peso_bruto: '',
		volumen: '',
		cajas: 0,
		formaPagoID: '',
		formaPagoDescrip: '',
		totalPesoNeto: '',
		totalPesoBruto: '',
		totalVolumen: '',
        notasVentas: [],
        notaVentaID:'',
	},

	methods: {

		getData: function() {

			if (this.cliente === '') {
				return;
			};

			this.getCliente();
		},

		getCliente: function() {

			var url = '/api/clientesNacionales/' + this.cliente;

			axios.get(url)
			.then(response => this.loadCliente(response.data))
			.catch(error => this.handleError(error))
		},

		loadCliente: function(data) {

			console.log(data);
			this.sucursales = data.sucursal;
			this.formaPagoID = data.forma_pago.id;
			this.formaPagoDescrip = data.forma_pago.descripcion;
			this.listaId = data.lista_precio.id;
			this.listaDescrip = data.lista_precio.descripcion;
			this.listaDetalle = data.lista_precio.detalle;
			this.canal = data.canal;
			this.descuento = data.canal.descuento;
			this.direccion = data.direccion;

		},

		loadProducto: function() {

			for (var i=0; i<this.listaDetalle.length; i++) {

				if (this.producto == this.listaDetalle[i].producto_id) {

					var formato = this.listaDetalle[i].producto.formato;
					this.codigo = this.listaDetalle[i].producto.codigo;
					this.descripcion = this.listaDetalle[i].producto.descripcion;
					this.precio = Math.round(this.listaDetalle[i].precio);
					this.peso_neto = this.listaDetalle[i].producto.peso_neto;
					this.peso_bruto = this.listaDetalle[i].producto.peso_bruto;
					this.volumen = this.listaDetalle[i].producto.volumen;

					if (this.listaDetalle[i].producto.marca.iaba) {

						this.iaba = 1;
					} else {
						this.iaba = 0;
					}
				}
			}
		},

		insertItem: function() {

			var validacion = this.validarItem();
			var item = {};
			if(!validacion) {
				alert('Error al agregar Item');
				return;
			}

			if (this.select === '') {

				item = {
					id: this.producto,
					codigo: this.codigo,
					descripcion: this.descripcion,
					cantidad: this.cantidad,
					descuento: this.descuento,
					precio: this.precio,
					iaba: this.iaba,
					peso_neto: this.peso_neto,
					peso_bruto: this.peso_bruto,
					volumen: this.volumen,
					total: (this.precio * this.cantidad).toFixed(2)
				};

				this.items.push(item);

			} else {

				this.items[this.select].id = this.producto;
				this.items[this.select].codigo = this.codigo;
				this.items[this.select].descripcion = this.descripcion;
				this.items[this.select].cantidad = this.cantidad;
				this.items[this.select].descuento = this.descuento;
				this.items[this.select].precio = this.precio;
				this.items[this.select].iaba = this.iaba;
				this.items[this.select].peso_neto = this.peso_neto;
				this.items[this.select].peso_bruto = this.peso_bruto;
				this.items[this.select].volumen = this.volumen;
				this.items[this.select].total = (this.precio * this.cantidad).toFixed(2);

				this.unselect();
			}

			this.calcular();
		},

		loadItem: function(key) {

			this.active = true;
			this.select = key;
			this.producto = this.items[key].id;
			this.codigo = this.items[key].codigo;
			this.descripcion = this.items[key].descripcion;
			this.cantidad = this.items[key].cantidad;
			this.precio = this.items[key].precio;
			this.peso_neto = this.items[key].peso_neto;
			this.peso_bruto = this.items[key].peso_bruto;
			this.volumen = this.items[key].volumen;
			this.iaba = this.items[key].iaba;
		},

		removeItem: function() {

			if (!(this.select === '')) {

				this.items.splice(this.select,1);
				this.unselect();
				this.calcular();
			}

		},

		calcular: function() {

			var subTotal = 0;
			var descuento = 0;
			var totaldescuento = 0;
			var neto = 0;
			var totalNeto = 0;
			var totalIaba = 0;
			var iaba = 0;
			var totalIva = 0;
			var iva = 0;
			var total = 0;
			var totalPesoNeto = 0;
			var totalPesoBruto = 0;
			var totalVolumen = 0;
			var pesoNeto = 0;
			var pesoBruto = 0;
			var volumen = 0;

			for (var i=0; this.items.length > i; i++) {

				itemSubTotal = this.items[i].precio * this.items[i].cantidad;
				descuento = ((this.items[i].precio * this.items[i].descuento) / 100) * this.items[i].cantidad;
				pesoNeto = this.items[i].peso_neto;
				pesoBruto = this.items[i].peso_bruto;
				volumen = this.items[i].volumen;

				neto = itemSubTotal - descuento;
				iva = (neto * 19) / 100;

				if (this.items[i].iaba) {

					iaba = (neto * 10) / 100;
				}

				subTotal += itemSubTotal;
				totaldescuento += descuento;
				totalIaba += iaba;
				totalIva += iva;
				totalNeto += neto;
				total += neto + iva + iaba;
				totalPesoNeto += pesoNeto;
				totalPesoBruto += pesoBruto;
				totalVolumen += volumen;
			}

			this.subTotal = subTotal.toFixed(2);
			this.totaldescuento = totaldescuento.toFixed(2);
			this.neto = totalNeto.toFixed(2);
			this.totalIaba = totalIaba.toFixed(2);
			this.iva = totalIva.toFixed(2);
			this.total = total.toFixed(2);
			this.totalPesoBruto = totalPesoBruto.toFixed(2);
			this.totalPesoNeto = totalPesoNeto.toFixed(2);
			this.totalVolumen = totalVolumen.toFixed(2);

		},

		unselect: function() {

			this.select = '';
			this.active = false;
		},

		validarItem: function() {

			var validar = false;

			if ((this.producto) && (this.cantidad) && (this.precio) ) {

				validar = true;
			}

			if (this.items.length >= 40) {

				alert('Maximo Numero de Items Por nota de Venta: 40');
				validar = false;
			}

			return validar;
		},

        getNotasVentas: function() {

            var url = '/api/notasVentas';
            axios.get(url)
            .then(response => this.loadNotasVentas(response.data))
            .catch(error => this.handleError(error))
        },

        loadNotasVentas: function(data) {

            this.notasVentas = data;
        },

        selectNV: function(id) {

            this.notaVentaID = id;
        },

        deselectNV: function() {

            this.notaVentaID = '';
        },

		handleError: function(error) {
			console.log(error);
			alert(error);
		},

	},

	updated() {
        $('.selectpicker').selectpicker('refresh');
    }
});
