var app = new Vue({

    el: '#vue-app',

    data: {

        cliente_id: cliente_id,
        sucursales: sucursales,
        descripcion_suc: '',
        direccion_suc: '',
        id_suc: ''
    },

    methods: {

        getSucursales: function() {

            $url = '/api/sucursalesClienteIntl/'+this.cliente_id;

			axios.get($url)
			.then(response => this.loadSucursales(response.data))
			.catch(error => this.handleError(error))
        },

        loadSucursales: function(data) {

            this.sucursales = data;
        },

        loadSucursal: function(id) {

            for (var i = 0; i < this.sucursales.length; i++) {

                if (id ==  this.sucursales[i].id) {

                    this.id_suc = this.sucursales[i].id;
                    this.descripcion_suc = this.sucursales[i].descripcion;
                    this.direccion_suc = this.sucursales[i].direccion;

                    break;
                }
            }

        },

        insertSucursal: function() {

            var validacion = this.validateInputs();

            if (validacion) {

                if (this.id_suc) {
                    this.updateSucursal();
                } else {
                    this.storeSucursal();
                }
            }

        },

        storeSucursal: function() {

            $url = '/api/sucursalesClienteIntl/'+this.cliente_id;

			axios.post($url, {
				cliente: this.cliente_id,
				descripcion: this.descripcion_suc,
				direccion: this.direccion_suc
			})
			.then(response => this.refresh())
			.catch(error => this.handleError(error))
        },

        updateSucursal: function() {

            $url = '/api/sucursalesClienteIntl/'+this.cliente_id;

			axios.put($url, {
				cliente: this.cliente_id,
                id: this.id_suc,
				descripcion: this.descripcion_suc,
				direccion: this.direccion_suc
			})
			.then(response => this.refresh())
			.catch(error => this.handleError(error))
        },

        deleteSucursal: function(id) {

            $url = '/api/sucursalesClienteIntl/' + id;

			axios.delete($url)
			.then(response => this.refresh())
			.catch(error => this.handleError(error))
        },

        validateInputs: function() {

            var validacion = true;

            if(!this.descripcion_suc) {

                validacion = false;
                alert('Debe ingresar descripcion');


            }else if (!this.direccion_suc) {

                validacion = false;
                alert('Debe ingresar Direccion');

            }else if (!this.cliente_id) {

                validacion = false;
                alert('No existe cliente Seleccionado');
            }

            return validacion;
        },

        clearInputs: function() {

            this.id_suc = '';
            this.descripcion_suc = '';
            this.direccion_suc = '';
        },

        refresh: function() {

            this.clearInputs();
            this.getSucursales();
        },

        handleError: function(error) {

            console.log(error);
			alert(error);
        }
    },
});
